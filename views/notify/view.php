<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Notify */

$this->title = $model->message;
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/account/index/']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="notify-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'message:ntext',
            [
                'attribute' => 'created_at',
                'label' => 'Дата',
                'format' => ['date', 'php:d.m.Y H:i'],
            ],
        ],
    ]) ?>

</div>
