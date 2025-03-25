<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\softDeletes;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function Users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
