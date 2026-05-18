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

class FinanceController extends Controller
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
                        'actions' => ['create-account', 'update-account', 'delete-account'],
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

    public function actionCreateAccount()
    {
        $model = new Account();
        $model->user_id    = Yii::$app->user->id;
        $model->is_active  = 1;
        $model->created_at = date('Y-m-d H:i:s');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Account created successfully.');
            return $this->redirect(['dashboard/index']);
        }

        // If validation fails, re-render dashboard with the model errors
        // so the modal reopens showing them
        Yii::$app->session->setFlash('openAccountModal', true);
        return $this->redirect(['dashboard/index']);
    }

    /**
     * Summary of actionUpdateAccount
     * @throws Yii\web\NotFoundHttpException
     * @return Yii\web\Response
     */
    public function actionUpdateAccount()
    {
        $id      = Yii::$app->request->post('id');
        $account = Account::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);

        if (!$account) {
            throw new \yii\web\NotFoundHttpException('Account not found.');
        }

        $account->load(Yii::$app->request->post()) && $account->save();

        Yii::$app->session->setFlash('success', 'Account updated.');
        return $this->redirect(['dashboard/index']);
    }

    /**
     * Summary of actionDeleteAccount
     * @throws Yii\web\NotFoundHttpException
     * @return Yii\web\Response
     */
    public function actionDeleteAccount()
    {
        $id      = Yii::$app->request->post('id');
        $account = Account::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);

        if (!$account) {
            throw new \yii\web\NotFoundHttpException('Account not found.');
        }

        $account->is_active = 0;
        $account->save(false);

        Yii::$app->session->setFlash('success', 'Account deleted.');
        return $this->redirect(['dashboard/index']);
    }
}
