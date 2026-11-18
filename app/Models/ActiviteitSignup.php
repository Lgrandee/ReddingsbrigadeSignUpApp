<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActiviteitSignup extends Model
{
    protected $fillable = [
        'activiteit_id',
        'user_id',
        'role',
    ];

    public function activiteit(): BelongsTo
    {
        return $this->belongsTo(Activiteit::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
