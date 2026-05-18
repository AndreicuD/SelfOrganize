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
        
        $this->layout = "dashboard_layout";
        return $this->render('index', [
            'user'             => $user,
            'accounts'         => $accounts,
            'totalBalance'     => $totalBalance,
            'accountModel'     => $accountModel,
            'editAccountModel' => $editAccountModel,
        ]);
    }
}
