<?php

namespace App\Models;

use App\Models\Concerns\Listable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory, Listable;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function getLinkAttribute(): string
    {
        if ($this->file) {
            return Storage::disk('public')->url($this->file);
        }

        return $this->url ?: '#';
    }
}
