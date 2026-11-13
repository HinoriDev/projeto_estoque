<?php

namespace App\Services;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    protected function getAll(string $modelClass, string $orderBy = 'id'): Collection
    {
        return $modelClass::query()->orderBy($orderBy)->get();
    }

    protected function createRecord(string $modelClass, array $data): Model
    {
        return $modelClass::query()->create($data);
    }

    protected function updateRecord(Model $record, array $data): Model
    {
        $record->update($data);
        return $record->refresh();
    }

    protected function deleteRecord(Model $record): void
    {
        $record->delete();
    }

    protected function buildWith(string $builderClass, Closure $configure): mixed
    {
        $builder = app($builderClass);
        $configure($builder);

        if (!method_exists($builder, 'build')) {
            throw new \InvalidArgumentException("{$builderClass} precisa implementar build().");
        }

        return $builder->build();
    }

}
