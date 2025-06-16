<?php
namespace app\services;

use app\models\Track;
use Yii;

class TrackValidator implements TrackValidatorInterface
{
    private ?string $lastError = null;

    public function validate(string $trackNumber, ?int $excludeId = null): bool
    {
        $query = Track::find()->where(['track_number' => $trackNumber]);

        if ($excludeId) {
            $query->andWhere(['!=', 'id', $excludeId]);
        }

        if ($query->exists()) {
            $this->lastError = 'Трек-номер уже существует';
            return false;
        }

        return true;
    }

    public function getLastError(): ?string
    {
        return $this->lastError;
    }
}