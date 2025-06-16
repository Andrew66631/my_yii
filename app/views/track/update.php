<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Track $model */

$this->title = 'Редактирование посылки: ' . $model->track_number;
$this->params['breadcrumbs'][] = ['label' => 'Посылки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->track_number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="track-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>