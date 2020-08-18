<?php

use yii\grid\GridView;
use yii\helpers\Html;

/**@var $provider yii\data\ActiveDataProvider */
?>

<div>
    <h2>Новые уведомления</h2>

    <?= GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'message',
                'format' => 'html',
                'value' => function($model) {
                    return Html::a(Html::encode($model->message), ['/notify/view', 'id' => $model->id]);
                }
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Дата',
                'format' => ['date', 'php:d.m.Y H:i'],
            ]
        ],
    ]); ?>

</div>