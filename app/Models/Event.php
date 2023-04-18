<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    protected $fillable = ['title', 'start_date', 'end_date', 'description', 'created_by'];

    protected $casts = [
      'start_date' => 'datetime',
      'end_date' => 'datetime',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user');
    }

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'event_department');
    }

    public function createdBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
