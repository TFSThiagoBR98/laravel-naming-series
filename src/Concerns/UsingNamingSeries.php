<?php

declare(strict_types=1);

namespace TFSThiagoBR98\LaravelNamingSeries\Contracts;

use Closure;
use TFSThiagoBR98\LaravelNamingSeries\Database\Builder;
use TFSThiagoBR98\LaravelNamingSeries\Exceptions\InvalidNamingSeriesFormat;
use TFSThiagoBR98\LaravelNamingSeries\Facades\LaravelNamingSeries;

trait UsingNamingSeries
{
    /**
     * Field => Format list for model fields
     *
     * @var array<string,string>
     */
    public static array $namingSeries = [];

    /**
     * Field => Format list for model fields
     *
     * @var array<string,string>
     */
    public static function getSerieList(): array
    {
        return self::namingSeries;
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    /**
     * Get a format for field
     *
     * @return string
     * @throws InvalidNamingSeriesFormat If field is missing from list
     */
    public static function getFieldSerieFormat(string $field): string
    {
        $list = self::getSerieList();
        if (array_key_exists($field, $list)) {
            return $list[$field];
        } else {
            throw new InvalidNamingSeriesFormat();
        }
    }

    /**
     * Generate unique keys for the model.
     *
     * @return void
     */
    public function setUniqueIds()
    {
        $uniqueIds = $this->uniqueIds();
        if (array_is_list($uniqueIds)) {
            $uniqueIds = array_fill_keys($uniqueIds, 'newUniqueId');
        }

        foreach ($uniqueIds as $column => $method) {
            if (empty($this->{$column})) {
                if ($method instanceof Closure) {
                    $this->{$column} = $method($column, $this);
                } else {
                    $this->{$column} = $this->{$method}($column, $this);
                }
            }
        }
    }

    public function getSeriesField(string $field, self $model) {
        return LaravelNamingSeries::generateIdForField($model, $field, null);
    }
}
