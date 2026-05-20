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

class TransactionController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['add', 'update', 'delete'],
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

    return $this->redirect(['dashboard/index']);
}

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

        return $this->redirect(['dashboard/index']);
    }

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
        return $this->redirect(['dashboard/index']);
    }
}