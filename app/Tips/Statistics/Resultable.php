<?php

declare(strict_types=1);

namespace App\Tips\Statistics;

interface Resultable
{
    public function getResultString(): string;

    public function doThresholdComparison(float $threshold, int $operator);

    public function hasPassed(): bool;

    public function getName(): string;
}
