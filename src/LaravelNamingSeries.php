<?php

declare(strict_types=1);

namespace TFSThiagoBR98\LaravelNamingSeries;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use TFSThiagoBR98\LaravelNamingSeries\Contracts\HasNamingSeries;

class LaravelNamingSeries
{
    protected function getConnection(): ?string
    {
        return config('naming-series.database.connection');
    }

    protected function getTable(): ?string
    {
        return config('naming-series.database.table', 'naming_series');
    }

    protected function splitWith(): ?string
    {
        return config('naming-series.split_with', '.');
    }

    protected function initialIncrement(): ?string
    {
        return config('naming-series.initial_increment', 1000);
    }

    public function generateIdForField(HasNamingSeries $model, string $field, ?string $connection = null): string {
        // Fetch format from Model
        $format = $model::getFieldSerieFormat($field);

        // Build prefix to fetch next sequence
        $prefix = $this->parseSerieFormat($format, null);

        // Fetch next Sequence
        $newCurrent = $this->getNextSequence(
            $model::class, $field, $prefix, $connection);

        // Build final ID
        $serie = $this->parseSerieFormat($format, $newCurrent);;

        // Save Sequence to Table
        DB::connection($connection ?? $this->getConnection())
            ->table($this->getTable())->upsert([
                [
                    'model' => $model::class,
                    'field' => $field,
                    'prefix' => $prefix,
                    'current' => $newCurrent,
                ]
            ], ['model', 'field', 'prefix'], ['current']);

        return $serie;
    }

    /**
     * Parser Serie Format from Model and gen new Key
     *
     * Based on Frappe Naming Series
     * @return array<int,string>
     */
    public function parseSerieFormat(string $format, ?int $nextId): string {
        $parts = explode($this->splitWith(), $format);
        $mount = '';
        $now = Carbon::nowWithSameTz();
        $series_set = false;

        foreach ($parts as $component) {
            if (str_starts_with($component, '#')) {
                if (!$series_set && $nextId != null) {
                    $pad = strlen($component);
                    $mount .= mb_str_pad("$nextId", $pad, '0', STR_PAD_LEFT);
                }
            } else if ($component == 'YY') {
                $mount .= $now->isoFormat('YY');
            } else if ($component == 'YYYY') {
                $mount .= $now->isoFormat('Y');
            } else if ($component == 'MM') {
                $mount .= $now->isoFormat('MM');
            } else if ($component == 'DD') {
                $mount .= $now->isoFormat('DD');
            } else if ($component == 'WW') {
                $mount .= $now->isoFormat('WW');
            } else if ($component == 'TS') {
                $mount .= $now->isoFormat('x');
            } else if ($component == 'TL') {
                $mount .= $now->isoFormat('X');
            } else {
                $mount .= $component;
            }
        }

        return $mount;
    }

    protected function getNextSequence(string $model, ?string $field, ?string $prefix, ?string $connection = null): int {
        $latestId = DB::connection($connection ?? $this->getConnection())
            ->table($this->getTable())
            ->where('model', $model)
            ->where('field', $field)
            ->where('prefix', $prefix)
            ->first();

        if ($latestId == null) {
            return 1;
        } else {
            return $latestId->current + $this->initialIncrement();
        }
    }
}