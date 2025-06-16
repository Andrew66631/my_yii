<?php

use app\models\Track;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\i18n\Formatter;

/** @var yii\web\View $this */
/** @var app\models\TrackSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tracks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="track-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить посылку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'track_number',
            'status',
            [
                'attribute' => 'created_at',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y');
                },
                'filter' => false,
            ],
            [
                'attribute' => 'updated_at',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->updated_at, 'php:d.m.Y');
                },
                'filter' => false,
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Track $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>