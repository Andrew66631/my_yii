<?php
namespace app\services;

use app\models\Track;

class StatusValidator implements StatusValidatorInterface
{
    private ?string $lastError = null;

    public function validate(string $status): bool
    {
        if (!in_array($status, $this->getAvailableStatuses())) {
            $this->lastError = sprintf(
                'Недопустимый статус. Допустимые значения: %s',
                implode(', ', $this->getAvailableStatuses())
            );
            return false;
        }
        return true;
    }

    public function getAvailableStatuses(): array
    {
        return Track::getStatuses();
    }

    public function getLastError(): ?string
    {
        return $this->lastError;
    }
}