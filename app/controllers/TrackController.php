<?php

namespace app\controllers;

use app\models\Track;
use app\models\TrackSearch;
use app\services\StatusValidatorInterface;
use app\services\TrackValidatorInterface;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

class TrackController extends Controller
{
    private TrackValidatorInterface $trackValidator;
    private StatusValidatorInterface $statusValidator;

    public function __construct(
        $id,
        $module,
        TrackValidatorInterface $trackValidator,
        StatusValidatorInterface $statusValidator,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->trackValidator = $trackValidator;
        $this->statusValidator = $statusValidator;
    }

    public function behaviors(): array
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex(): string
    {
        $searchModel = new TrackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate(): Response|string
    {
        $model = new Track();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            if ($this->validateAndSave($model)) {
                Yii::$app->session->setFlash('success', 'Посылка успешно создана');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate(int $id): Response|string
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            if ($this->validateAndSave($model)) {
                Yii::$app->session->setFlash('success', 'Изменения сохранены');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete(int $id): Response
    {
        try {
            $model = $this->findModel($id);

            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'Запись успешно удалена');
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось удалить запись');
            }
        } catch (NotFoundHttpException $e) {
            Yii::$app->session->setFlash('error', 'Запрашиваемая запись не найдена');
        } catch (\Exception $e) {
            Yii::error("Ошибка удаления посылки #{$id}: {$e->getMessage()}");
            Yii::$app->session->setFlash('error', 'Произошла ошибка при удалении');
        }

        return $this->redirect(['index']);
    }

    protected function findModel(int $id): Track
    {
        if (($model = Track::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая запись не найдена');
    }

    private function validateAndSave(Track $model): bool
    {
        try {
            if (!$this->trackValidator->validate($model->track_number, $model->isNewRecord ? null : $model->id)) {
                $model->addError('track_number', $this->trackValidator->getLastError());
            }

            if (!$this->statusValidator->validate($model->status)) {
                $model->addError('status', $this->statusValidator->getLastError());
            }

            if ($model->hasErrors()) {
                return false;
            }

            return $model->save();
        } catch (\Exception $e) {
            Yii::error("Ошибка сохранения посылки: {$e->getMessage()}");
            Yii::$app->session->setFlash('error', 'Произошла ошибка при сохранении');
            return false;
        }
    }
}