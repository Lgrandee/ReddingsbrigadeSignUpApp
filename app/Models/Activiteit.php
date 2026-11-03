<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activiteit extends Model
{
    protected $fillable = [
        'type',
        'date',
        'time',
        'location',
        'description'
    ];
}