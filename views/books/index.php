<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Книги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function($model) {
                    return Html::a($model->title, ['/books/view', 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>
