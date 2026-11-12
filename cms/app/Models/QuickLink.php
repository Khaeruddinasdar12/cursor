<?php

namespace App\Models;

use App\Models\Concerns\Listable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class QuickLink extends Model
{
    use Listable;

    public const HERO = 'hero';

    public const SERVICE_CTA = 'service_cta';

    public const PLACEMENTS = [
        self::HERO => 'Kartu Layanan Cepat (Hero)',
        self::SERVICE_CTA => 'Bagian Layanan Terpadu',
    ];

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function scopePlacement(Builder $query, string $placement): Builder
    {
        return $query->where('placement', $placement);
    }
}
