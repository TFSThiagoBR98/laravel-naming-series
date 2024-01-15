<?php

declare(strict_types=1);

namespace TFSThiagoBR98\LaravelNamingSeries\Database;

use Closure;
use Illuminate\Database\Eloquent\Builder as BaseBuilder;

class Builder extends BaseBuilder
{
    /**
     * Add unique IDs to the inserted values.
     *
     * @return array
     */
    protected function addUniqueIdsToUpsertValues(array $values)
    {
        if (! $this->model->usesUniqueIds()) {
            return $values;
        }

        $uniqueIds = $this->model->uniqueIds();
        if (array_is_list($uniqueIds)) {
            $uniqueIds = array_fill_keys($uniqueIds, 'newUniqueId');
        }

        foreach ($uniqueIds as $uniqueIdAttribute => $method) {
            foreach ($values as &$row) {
                if (! array_key_exists($uniqueIdAttribute, $row)) {
                    if ($method instanceof Closure) {
                        $row = array_merge([$uniqueIdAttribute => $method($uniqueIdAttribute, $this->model)], $row);
                    } else {
                        $row = array_merge([$uniqueIdAttribute => $this->model->{$method}($uniqueIdAttribute, $this->model)], $row);
                    }
                }
            }
        }

        return $values;
    }
}
