<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\base\Security;
use yii\mail\MailerInterface;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

use app\models\Account;
use app\models\Transaction;

class DashboardController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly MailerInterface $mailer,
        private readonly Security $security,
        $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
            'captcha' => [
                'class' => CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'transparent' => true,
            ],
        ];
    }

    /**
     * Displays user dashboard.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $user = Yii::$app->user->identity;

        $accounts = Account::getByUser(Yii::$app->user->id);
        $totalBalance = Account::getTotalBalance(Yii::$app->user->id);

        $accountModel     = new Account();
        $editAccountModel = new Account();

        $recentTransactions = Transaction::getByUser(Yii::$app->user->id, 8);
        $transactionModel = new Transaction();
        $balanceHistory7  = Account::getBalanceHistory(Yii::$app->user->id, 7);
        $balanceHistory30 = Account::getBalanceHistory(Yii::$app->user->id, 30);
        $incomeHistory7   = Account::getDailyTotals(Yii::$app->user->id, 7,  'income');
        $incomeHistory30  = Account::getDailyTotals(Yii::$app->user->id, 30, 'income');
        $expenseHistory7  = Account::getDailyTotals(Yii::$app->user->id, 7,  'expense');
        $expenseHistory30 = Account::getDailyTotals(Yii::$app->user->id, 30, 'expense');
        $transferHistory7  = Account::getDailyTotals(Yii::$app->user->id, 7,  'transfer_out');
        $transferHistory30 = Account::getDailyTotals(Yii::$app->user->id, 30, 'transfer_out');

        $monthlyStats = Account::getMonthlyStats(Yii::$app->user->id);


        return $this->render('index', [
            'user'             => $user,
            'accounts'         => $accounts,
            'totalBalance'     => $totalBalance,
            'accountModel'     => $accountModel,
            'editAccountModel' => $editAccountModel,
            'recentTransactions'  => $recentTransactions,
            'transactionModel' => $transactionModel,
            'balanceHistory7'  => $balanceHistory7,
            'balanceHistory30' => $balanceHistory30,
            'incomeHistory7'   => $incomeHistory7,
            'incomeHistory30'  => $incomeHistory30,
            'expenseHistory7'  => $expenseHistory7,
            'expenseHistory30' => $expenseHistory30,
            'transferHistory7'  => $transferHistory7,
            'transferHistory30' => $transferHistory30,
            'monthlyStats' => $monthlyStats,
        ]);
    }
}
