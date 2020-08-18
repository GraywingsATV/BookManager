<?php

/* @var $this yii\web\View */

$this->title = 'Главная';

use yii\helpers\Html; ?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Добро пожаловать!</h1>

        <p class="lead">Для просмотра книг в наличии и резервирования необходима
            <?= Html::a('авторизация', ['/site/login']) ?></p>
    </div>
</div>
