<?php

namespace app\controllers;

use app\models\Notify;
use app\models\search\BookSearch;
use app\models\search\NotifySearch;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Личный кабинет пользователя
 *
 * Class AccountController
 * @package app\controllers
 */
class AccountController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
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
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Главная страница ЛК.
     *
     * @return string
     */
    public function actionIndex()
    {
        $bookSearch = new BookSearch();
        $currentProvider = $bookSearch->search([]);
        $currentProvider->query
            ->andWhere(['reserve.user_id' => \Yii::$app->user->identity->getId()])
            ->andWhere(['reserve.status' => \app\models\Reserve::UNAVAILABLE]);

        $reservedProvider = $bookSearch->search([]);
        $reservedProvider->query
            ->andWhere(['reserve.user_id' => \Yii::$app->user->identity->getId()])
            ->andWhere(['reserve.status' => \app\models\Reserve::RESERVED]);

        $notifySearch = new NotifySearch();
        $newNotifyProvider = $notifySearch->search([]);
        $newNotifyProvider->query
            ->andWhere(['user_id' => \Yii::$app->user->identity->getId()])
            ->andWhere(['status' => Notify::STATUS_NEW]);

        $oldNotifyProvider = $notifySearch->search([]);
        $oldNotifyProvider->query
            ->andWhere(['user_id' => \Yii::$app->user->identity->getId()])
            ->andWhere(['status' => Notify::STATUS_VIEWED]);

        return $this->render('index', [
            'currentProvider' => $currentProvider,
            'reservedProvider' => $reservedProvider,
            'newNotifyProvider' => $newNotifyProvider,
            'oldNotifyProvider' => $oldNotifyProvider,
        ]);
    }
}
