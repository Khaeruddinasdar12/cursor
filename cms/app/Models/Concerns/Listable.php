<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait Listable
{
    public function scopeActive(Builder $query): Builder
    {
        return $query->where($query->getModel()->getTable().'.is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy($query->getModel()->getTable().'.sort')->orderBy($query->getModel()->getTable().'.id');
    }
}
