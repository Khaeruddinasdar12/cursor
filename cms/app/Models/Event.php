<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['event_date' => 'date', 'is_published' => 'boolean'];
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->whereDate('event_date', '>=', today())
            ->orderBy('event_date')
            ->orderBy('id');
    }

    public function getPlaceAttribute(): string
    {
        return collect([$this->location, $this->time])->filter()->implode(' · ');
    }
}
