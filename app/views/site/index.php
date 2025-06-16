<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Главная';
?>

<div class="site-index">

    <h1>Добро пожаловать!</h1>

    <p>Выберите действие:</p>
    <div class="btn-group" role="group" aria-label="Навигация">
        <?= Html::a('Посылки', ['track/'], ['class' => 'btn btn-primary']) ?>
    </div>

</div>
