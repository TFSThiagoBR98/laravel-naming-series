<?php

declare(strict_types=1);

namespace TFSThiagoBR98\LaravelNamingSeries\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string generateIdForField(TFSThiagoBR98\LaravelNamingSeries\Contracts\HasNamingSeries $model, string $field, ?string $connection = null): string
 *
 * @see \TFSThiagoBR98\LaravelNamingSeries\LaravelNamingSeries
 */
class LaravelNamingSeries extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \TFSThiagoBR98\LaravelNamingSeries\LaravelNamingSeries::class;
    }
}
