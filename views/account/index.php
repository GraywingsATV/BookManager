<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;

/**@var $currentProvider yii\data\ActiveDataProvider */
/**@var $reservedProvider yii\data\ActiveDataProvider */
/**@var $newNotifyProvider yii\data\ActiveDataProvider */
/**@var $oldNotifyProvider yii\data\ActiveDataProvider */

$this->title = 'Личный кабинет';
?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => 'Книги',
                'items' => [
                    [
                        'label' => 'На руках',
                        'content' => $this->render('current', ['provider' => $currentProvider]),
                        'active' => true
                    ],
                    [
                        'label' => 'Зарезервированы',
                        'content' => $this->render('reserved', ['provider' => $reservedProvider]),
                    ],
                ]
            ],
            [
                'label' => 'Уведомления',
                'linkOptions' => ['id' => 'notifyTab'],
                'items' => [
                    [
                        'label' => 'Новые',
                        'headerOptions' => [
                            'id' => 'headerOptions'
                        ],
                        'options' => [
                            'id' => 'options'
                        ],
                        'content' => $this->render('notify_new', ['provider' => $newNotifyProvider]),
                    ],
                    [
                        'label' => 'Архив',
                        'content' => $this->render('notify_old', ['provider' => $oldNotifyProvider]),
                    ]
                ]
            ]
        ]
    ]) ?>
</div>
