<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = ['title'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'department_id', 'id');
    }
}
