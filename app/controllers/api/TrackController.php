<?php

namespace app\controllers\api;

use app\models\Track;
use app\services\StatusValidatorInterface;
use app\services\TrackValidatorInterface;
use sizeg\jwt\JwtHttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;
use app\models\TrackSearch;

class TrackController extends ActiveController
{
    public $modelClass = 'app\models\Track';

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

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => JwtHttpBearerAuth::class,
            'optional' => [
                'index',
                'view',
                'options'
            ],
        ];

        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        unset($actions['create'], $actions['update']);

        return $actions;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if (in_array($action, ['index', 'view'])) {
            return true;
        }

        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Требуется авторизация');
        }

        return true;
    }

    public function prepareDataProvider()
    {
        $searchModel = new TrackSearch();
        return $searchModel->search(Yii::$app->request->queryParams);
    }

    public function actionCreate()
    {
        $model = new Track();
        $model->load(Yii::$app->request->post(), '');

        if ($this->validateAndSave($model)) {
            $this->logAction('create', $model);
            Yii::$app->response->setStatusCode(201);
            return $model;
        }

        Yii::$app->response->setStatusCode(422);
        return $model->errors;
    }

    public function actionUpdate($id)
    {
        $this->checkAccess('update');

        $model = $this->findModel($id);
        $model->load(Yii::$app->request->getBodyParams(), '');

        if ($this->validateAndSave($model)) {
            $this->logAction('update', $model);
            return $model;
        }

        Yii::$app->response->setStatusCode(422);
        return $model->errors;
    }

    public function actionBatchStatusUpdate()
    {
        $this->checkAccess('batch-status-update');

        $request = Yii::$app->request;
        $trackIds = explode(',', $request->post('track_ids', []));
        $newStatus = $request->post('status');

        if (empty($trackIds)) {
            throw new BadRequestHttpException('Не указаны ID треков');
        }

        if (!$this->statusValidator->validate($newStatus)) {
            Yii::$app->response->setStatusCode(422);
            return ['error' => $this->statusValidator->getLastError()];
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $updatedCount = Track::updateAll(
                ['status' => $newStatus],
                ['id' => $trackIds]
            );

            $transaction->commit();
            $this->logBatchUpdate($trackIds, $newStatus);

            return [
                'success' => true,
                'updated_count' => $updatedCount
            ];
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Batch update failed: " . $e->getMessage());
            throw new BadRequestHttpException('Ошибка массового обновления');
        }
    }

    protected function validateAndSave(Track $model): bool
    {
        if (!$this->trackValidator->validate($model->track_number, $model->isNewRecord ? null : $model->id)) {
            $model->addError('track_number', $this->trackValidator->getLastError());
        }

        if (!$this->statusValidator->validate($model->status)) {
            $model->addError('status', $this->statusValidator->getLastError());
        }
        return !$model->hasErrors() && $model->save();
    }

    protected function logAction(string $action, Track $model): void
    {
        Yii::info(sprintf(
            "Track %s: ID=%d, Number=%s, Status=%s",
            $action,
            $model->id,
            $model->track_number,
            $model->status
        ), 'api');
    }

    protected function logBatchUpdate(array $trackIds, string $newStatus): void
    {
        Yii::info(sprintf(
            "Batch status update: %d tracks to status '%s'",
            count($trackIds),
            $newStatus
        ), 'api');
    }

    protected function findModel(int $id): Track
    {
        if (($model = Track::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрашиваемая запись не найдена');
    }
}