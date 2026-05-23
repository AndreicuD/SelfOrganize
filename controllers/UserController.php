<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\SignupForm;
use yii\captcha\CaptchaAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\base\Security;
use yii\mail\MailerInterface;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

use app\models\ChangePasswordForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\User;

class UserController extends Controller
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
                'only' => ['signup', 'logout'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'settings', 'save-accent', 'save-currency', 'change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['request-password-reset', 'reset-password', 'verify-email'],
                        'allow' => true,
                        'roles' => ['@', '?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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

    public function actionSignup(): Response|string
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Account created! You can now log in.');
            return $this->redirect(['user/login']);
        }

        return $this->render('signup', ['model' => $model]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm($this->security);

        if ($model->load($this->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', ['model' => $model]);
    }
    

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSettings()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['user/login']);
        }

        $userModel = Yii::$app->user->identity;
        $changePasswordModel = new ChangePasswordForm();

        if ($userModel->load(Yii::$app->request->post()) && $userModel->save()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Changes saved successfully.'));
            return $this->redirect(['user/settings']);
        }

        return $this->render('settings', [
            'userModel'           => $userModel,
            'changePasswordModel' => $changePasswordModel,
        ]);
    }

    public function actionSaveAccent()
    {
        $user = User::findOne(Yii::$app->user->id);
        $user->preferred_accent = Yii::$app->request->post('accent');
        $user->save(false);

        Yii::$app->session->setFlash('success', 'Accent color saved.');
        return $this->redirect(['user/settings']);
    }

    public function actionSaveCurrency()
    {
        $user = User::findOne(Yii::$app->user->id);
        if ($user->load(Yii::$app->request->post()) && $user->save(false)) {
            Yii::$app->session->setFlash('success', 'Preferred currency saved.');
        }
        return $this->redirect(['user/settings']);
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Password changed successfully.'));
        } else {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Could not change password. Please check your inputs.'));
        }

        return $this->redirect(['user/settings']);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (\yii\base\InvalidArgumentException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');
            return $this->redirect(['user/login']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
