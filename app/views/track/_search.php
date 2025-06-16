<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Track;

/** @var yii\web\View $this */
/** @var app\models\TrackSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="track-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'id' => 'track-search-form',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'track_number') ?>

    <?= $form->field($model, 'status')->dropDownList(
        Track::getStatusLabels(),
        [
            'prompt' => 'Выберите статус...',
            'class' => 'form-control'
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сбросить поиск', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>