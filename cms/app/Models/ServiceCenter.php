<?php

namespace App\Models;

use App\Models\Concerns\Listable;
use Illuminate\Database\Eloquent\Model;

class ServiceCenter extends Model
{
    use Listable;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['features' => 'array', 'is_active' => 'boolean'];
    }
}
