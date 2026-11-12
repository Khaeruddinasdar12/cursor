<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort')->orderBy('id');
    }

    public function rootItems(): HasMany
    {
        return $this->items()->whereNull('parent_id');
    }

    /**
     * Item menu tingkat atas (aktif) beserta anak-anaknya, untuk slug menu tertentu.
     */
    public static function tree(string $slug)
    {
        $menu = static::query()->where('slug', $slug)->where('is_active', true)->first();

        if (! $menu) {
            return collect();
        }

        $items = $menu->items()->where('is_active', true)->get();
        $children = $items->whereNotNull('parent_id')->groupBy('parent_id');

        return $items->whereNull('parent_id')->values()->each(
            fn (MenuItem $item) => $item->setRelation('activeChildren', $children->get($item->id, collect())->values())
        );
    }
}
