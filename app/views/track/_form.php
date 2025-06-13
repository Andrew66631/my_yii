<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Track;

/** @var yii\web\View $this */
/** @var app\models\Track $model */
/** @var ActiveForm $form */
?>

<div class="track-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'track_number')->textInput([
        'maxlength' => true,
        'placeholder' => 'Введите трек-номер'
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        Track::getStatusLabels(),
        [
            'prompt' => 'Выберите статус...',
            'class' => 'form-control'
        ]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>