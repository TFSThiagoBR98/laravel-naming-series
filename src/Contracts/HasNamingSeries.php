<?php

declare(strict_types=1);

namespace TFSThiagoBR98\LaravelNamingSeries\Contracts;

interface HasNamingSeries
{
    public static function getSerieList(): array;
    public static function getFieldSerieFormat(string $field): string;
}
