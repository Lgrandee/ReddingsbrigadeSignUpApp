<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activiteit extends Model
{
    protected $table = 'activiteiten';
    protected $fillable = [
        'type',
        'date',
        'time',
        'location',
        'description',
        'deadline_at',
        'required_roles',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'deadline_at' => 'datetime',
            'required_roles' => 'array',
        ];
    }

    public function signups(): HasMany
    {
        return $this->hasMany(ActiviteitSignup::class);
    }
}