<?php

use yii\grid\GridView;
use yii\helpers\Html;

/**@var $provider yii\data\ActiveDataProvider */

?>
<div>

    <h3>Книги, которые вы взяли</h3>

    <?= GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function($model) {
                    return Html::a($model->title, ['/books/view', 'id' => $model->id]);
                }
            ],
            [
                'label' => 'Дата регистрации',
                'format' => ['date', 'php:d.m.Y H:i'],
                'value' => function($model) {
                    return $model->reservation->updated_at;
                }
            ]
        ],
    ]); ?>

</div>