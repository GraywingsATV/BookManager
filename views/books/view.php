<?php

use app\models\Notify;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $buttons array */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$buttons = [];
if($model->isAvailable()) {
    $buttons[] = [
        'title' => 'Взять книгу',
        'url' => ['take-book', 'id' => $model->id],
        'options' => ['class' => 'btn btn-primary']
    ];
}
if($model->canReserve()) {
    $buttons[] = [
        'title' => 'Зарезервировать',
        'url' => ['reserve', 'id' => $model->id],
        'options' => ['class' => 'btn btn-primary']
    ];
}
if($model->canSubmit()) {
    $buttons[] = [
        'title' => 'Сдать',
        'url' => ['submit-book', 'id' => $model->id],
        'options' => ['class' => 'btn btn-success']
    ];
}
if($model->isReserved()) {
    $buttons[] = [
        'title' => 'Отменить резервирование',
        'url' => ['reserve-cancel', 'id' => $model->id],
        'options' => [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Вы уверены? При повторном резервировании вы будете перемещены в конец очереди.',
                'method' => 'post',
            ]
        ]
    ];
}

?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php foreach($buttons as $button) {
            echo Html::a($button['title'], $button['url'], $button['options']);
            echo PHP_EOL;
        } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            [
                'label' => 'Очередь резервирования',
                'format' => 'html',
                'value' => function($model) {
                    return join('<br>', $model->reserveOrder);
                }
            ]
        ],
    ]) ?>

</div>
