<?php

namespace App\Models;

use App\Models\Concerns\Listable;
use Illuminate\Database\Eloquent\Model;

class OfficeHour extends Model
{
    use Listable;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'is_closed' => 'boolean'];
    }
}
