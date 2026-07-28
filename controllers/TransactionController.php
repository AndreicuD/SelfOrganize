<?php
declare(strict_types=1);
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use app\models\Transaction;
use app\models\Account;
use app\models\ExchangeRate;
use app\models\MonthlyLimit;

class TransactionController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['add', 'update', 'delete', 'update-limit', 'index'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    /**
     * Shows all the users transactions
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $userId  = Yii::$app->user->id;
        $request = Yii::$app->request;

        // --- Date range from preset or custom inputs ---
        $preset = $request->get('preset', '');
        $from   = $request->get('from', '');
        $to     = $request->get('to', '');

        if ($preset) {
            switch ($preset) {
                case 'this_month':
                    $from = date('Y-m-01');
                    $to   = date('Y-m-t');
                    break;
                case 'last_month':
                    $from = date('Y-m-01', strtotime('first day of last month'));
                    $to   = date('Y-m-t',  strtotime('last day of last month'));
                    break;
                case 'last_7':
                    $from = date('Y-m-d', strtotime('-7 days'));
                    $to   = date('Y-m-d');
                    break;
                case 'this_year':
                    $from = date('Y-01-01');
                    $to   = date('Y-12-31');
                    break;
                case 'all':
                default:
                    $from = '';
                    $to   = '';
                    break;
            }
        }

        // --- Search ---
        $q = $request->get('q', '');

        // --- Base query ---
        $query = Transaction::find()
            ->joinWith('account')
            ->where(['transaction.user_id' => $userId]);

        if ($from) $query->andWhere(['>=', 'transaction_date', $from]);
        if ($to)   $query->andWhere(['<=', 'transaction_date', $to]);

        if ($q) {
            $query->andWhere([
                'or',
                ['like', 'transaction.note',   $q],
                ['like', 'transaction.amount', $q],
                ['like', 'account.name',       $q],
            ]);
        }

        $query->orderBy(['transaction_date' => SORT_DESC, 'transaction.created_at' => SORT_DESC]);

        // --- Stats (unpaginated) ---
        $allFiltered = $query->with('account')->all();

        $stats = [
            'income'    => 0.0,
            'expense'   => 0.0,
            'transfers' => 0.0,
            'net'       => 0.0,
        ];

        foreach ($allFiltered as $t) {
            match ($t->type) {
                'income'       => $stats['income']    += (float)$t->amount,
                'expense'      => $stats['expense']   += (float)$t->amount,
                'transfer_out' => $stats['transfers'] += (float)$t->amount,
                default        => null,
            };
        }
        $stats['net'] = $stats['income'] - $stats['expense'];

        // --- Pagination ---
        $totalCount = $query->count();
        $pagination = new \yii\data\Pagination([
            'totalCount' => $totalCount,
            'pageSize'   => 15,
            'pageSizeParam' => false,
        ]);

        $transactions = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $editTransactionModel = new Transaction();
        $accounts = Account::getByUser($userId);

        $monthlyStats = Account::getMonthlyStats(Yii::$app->user->id);
        $monthlyLimit = MonthlyLimit::getByUser(Yii::$app->user->id);
        if ($monthlyLimit === null) {
            $monthlyLimit = new MonthlyLimit();
            $monthlyLimit->user_id = Yii::$app->user->id;
        }

        return $this->render('index', [
            'user' => $user,

            'transactions'         => $transactions,
            'editTransactionModel' => $editTransactionModel,
            'accounts'             => $accounts,
            'pagination'           => $pagination,
            'stats'                => $stats,
            'q'                    => $q,
            'from'                 => $from,
            'to'                   => $to,
            'preset'               => $preset,
            'totalCount'           => $totalCount,
            'monthlyStats' => $monthlyStats,
            'monthlyLimit' => $monthlyLimit,
        ]);
    }

    /**
     * Add a new Transaction to the DB
     * @throws Yii\web\NotFoundHttpException
     * @return Yii\web\Response
     */
    public function actionAdd()
    {
        $model = new Transaction();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $account = Account::findOne([
                'id'      => $model->account_id,
                'user_id' => Yii::$app->user->id,
            ]);

            if (!$account) {
                throw new NotFoundHttpException('Account not found.');
            }

            var_dump(Yii::$app->request->post());
            
            $model->transaction_date = date(
                'Y-m-d H:i:s',
                strtotime($model->transaction_date)
            );

            $model->currency = $account->currency;

            if ($model->type === 'transfer_out') {
                $toAccountId = Yii::$app->request->post('Transaction')['to_account_id'] ?? null;
                $toAccount   = Account::findOne(['id' => $toAccountId, 'user_id' => Yii::$app->user->id]);

                if (!$toAccount) {
                    Yii::$app->session->setFlash('error', 'Destination account not found.');
                    return $this->redirect(['dashboard/index']);
                }

                if ($account->balance < $model->amount) {
                    Yii::$app->session->setFlash('error', 'Insufficient balance.');
                    return $this->redirect(['dashboard/index']);
                }

                // Convert amount to destination currency
                $convertedAmount = ExchangeRate::convert(
                    (float) $model->amount,
                    $account->currency,
                    $toAccount->currency
                );

                // Save transfer_out in source currency
                $model->type = 'transfer_out';
                $model->save(false);

                // Save transfer_in in destination currency
                $transferIn                         = new Transaction();
                $transferIn->user_id                = Yii::$app->user->id;
                $transferIn->account_id             = $toAccount->id;
                $transferIn->type                   = 'transfer_in';
                $transferIn->amount                 = round($convertedAmount, 2);
                $transferIn->currency               = $toAccount->currency;
                $transferIn->note                   = $model->note;
                $transferIn->related_transaction_id = $model->id;
                $transferIn->transaction_date       = $model->transaction_date;
                $transferIn->save(false);

                // Link back
                $model->related_transaction_id = $transferIn->id;
                $model->save(false);

                // Update balances
                $account->balance   -= $model->amount;
                $toAccount->balance += round($convertedAmount, 2);
                $account->save(false);
                $toAccount->save(false);

                Yii::$app->session->setFlash('success', 'Transfer completed.');

            } else {
                if ($model->isCredit()) {
                    $account->balance += $model->amount;
                } else {
                    if ($account->balance < $model->amount) {
                        Yii::$app->session->setFlash('error', 'Insufficient balance.');
                        return $this->redirect(['dashboard/index']);
                    }
                    $account->balance -= $model->amount;
                }

                $model->currency = $account->currency;

                if ($model->save(false) && $account->save(false)) {
                    Yii::$app->session->setFlash('success', 'Transaction saved.');
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save transaction.');
                }
            }
        } else {
            Yii::$app->session->setFlash('error', implode(' ', $model->getFirstErrors()));
        }

        return $this->redirect(['transaction/index']);
    }

    /**
     * Update Transaction info in DB
     * @throws Yii\web\NotFoundHttpException
     * @return Yii\web\Response
     */
    public function actionUpdate()
    {
        $id    = Yii::$app->request->post('id');
        $model = Transaction::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);

        if (!$model) {
            throw new NotFoundHttpException('Transaction not found.');
        }

        $oldAmount   = $model->amount;
        $oldIsCredit = $model->isCredit();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $account = Account::findOne([
                'id'      => $model->account_id,
                'user_id' => Yii::$app->user->id,
            ]);

            if (!$account) {
                throw new NotFoundHttpException('Account not found.');
            }

            // Reverse the old transaction effect
            if ($oldIsCredit) {
                $account->balance -= $oldAmount;
            } else {
                $account->balance += $oldAmount;
            }

            // Apply the new transaction effect
            if ($model->isCredit()) {
                $account->balance += $model->amount;
            } else {
                $account->balance -= $model->amount;
            }

            if ($model->save(false) && $account->save(false)) {
                Yii::$app->session->setFlash('success', 'Transaction updated.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update transaction.');
            }
        }

        return $this->redirect(['transaction/index']);
    }

    /**
     * Delete Transaction from DB
     * @throws Yii\web\NotFoundHttpException
     * @return Yii\web\Response
     */
    public function actionDelete()
    {
        $id    = Yii::$app->request->post('id');
        $model = Transaction::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);

        if (!$model) {
            throw new NotFoundHttpException('Transaction not found.');
        }

        $account = Account::findOne([
            'id'      => $model->account_id,
            'user_id' => Yii::$app->user->id,
        ]);

        if ($account) {
            // Reverse the transaction effect on the balance
            if ($model->isCredit()) {
                $account->balance -= $model->amount;
            } else {
                $account->balance += $model->amount;
            }
            $account->save(false);
        }

        $model->delete();

        Yii::$app->session->setFlash('success', 'Transaction deleted.');
        return $this->redirect(['transaction/index']);
    }

    /**
     * Update or Create the spending limit for the user
     * @return Yii\web\Response
     */
    public function actionUpdateLimit()
    {
        $model = MonthlyLimit::findOne([
            'user_id' => Yii::$app->user->id,
        ]);

        if ($model === null) {
            $model = new MonthlyLimit();
            $model->user_id = Yii::$app->user->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Monthly budget updated.');
        } else {
            Yii::$app->session->setFlash(
                'error',
                print_r($model->getErrors(), true)
            );
            // Yii::$app->session->setFlash('error', 'Failed to save monthly budget.');
        }

        return $this->redirect(['transaction/index']);
    }
}