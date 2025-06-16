<?php
namespace app\services;

interface TrackValidatorInterface
{
    public function validate(string $trackNumber, ?int $excludeId = null): bool;
    public function getLastError(): ?string;
}