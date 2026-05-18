<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * @property string $base       [varchar(3)]
 * @property string $target     [varchar(3)]
 * @property float  $rate       [decimal(15,6)]
 * @property string $fetched_at [datetime]
 */
class ExchangeRate extends ActiveRecord
{
    // Free, no API key needed
    const API_URL = 'https://api.exchangerate-api.com/v4/latest/';

    // How many hours before rates are considered stale
    const CACHE_HOURS = 24;

    public static function tableName(): string
    {
        return 'exchange_rates';
    }

    public function rules(): array
    {
        return [
            [['base', 'target'], 'required'],
            [['base', 'target'], 'string', 'max' => 3],
            [['rate'], 'number', 'min' => 0],
        ];
    }

    // --- Core conversion ---

    /**
     * Convert an amount from one currency to another.
     * Fetches/refreshes rates automatically if stale.
     */
    public static function convert(float $amount, string $from, string $to): float
    {
        if ($from === $to) return $amount;

        $rate = self::getRate($from, $to);
        if ($rate === null) return $amount; // fallback: return unconverted

        return $amount * $rate;
    }

    /**
     * Get rate from DB, refreshing if stale or missing.
     */
    public static function getRate(string $from, string $to): ?float
    {
        $record = self::findOne(['base' => $from, 'target' => $to]);

        $isStale = $record === null || self::isStale($record->fetched_at);

        if ($isStale) {
            self::fetchAndStore($from);
            $record = self::findOne(['base' => $from, 'target' => $to]);
        }

        return $record ? (float) $record->rate : null;
    }

    /**
     * Fetch all rates for a base currency from the API and store them.
     */
    public static function fetchAndStore(string $base): bool
    {
        $url  = self::API_URL . strtoupper($base);
        $json = @file_get_contents($url);

        if (!$json) {
            Yii::warning("ExchangeRate: failed to fetch rates for $base", __METHOD__);
            return false;
        }

        $data = json_decode($json, true);
        if (empty($data['rates'])) return false;

        $now = date('Y-m-d H:i:s');

        foreach ($data['rates'] as $target => $rate) {
            $record = self::findOne(['base' => $base, 'target' => $target]);

            if (!$record) {
                $record = new self();
                $record->base   = $base;
                $record->target = $target;
            }

            $record->rate       = $rate;
            $record->fetched_at = $now;
            $record->save(false); // skip validation for speed
        }

        Yii::info("ExchangeRate: refreshed rates for $base", __METHOD__);
        return true;
    }

    /**
     * Returns true if the time since last fetch is greater than CACHE_HOURSE;
     * <br>
     * CACHE_HOURS = 24 by default;
     * @param string $fetchedAt
     * @return bool
     */
    private static function isStale(string $fetchedAt): bool
    {
        $age = (time() - strtotime($fetchedAt)) / 3600; // hours
        return $age >= self::CACHE_HOURS;
    }
}