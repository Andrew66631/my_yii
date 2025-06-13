<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Track $model */

$this->title = 'Создание посылки';
$this->params['breadcrumbs'][] = ['label' => 'Посылки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="track-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>