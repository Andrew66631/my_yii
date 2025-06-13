<?php
namespace app\services;

interface StatusValidatorInterface
{
    public function validate(string $status): bool;
    public function getAvailableStatuses(): array;
    public function getLastError(): ?string;
}