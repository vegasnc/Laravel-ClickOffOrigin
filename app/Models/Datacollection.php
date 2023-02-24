<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Datacollection extends Authenticatable
{
    protected $connection ="mysql";

    protected $table ="datacollection";

    protected $fillable = [
        'asset',
        'address',
        'quantity',
        'condition',
        'tagged',
        'color',
    ];

    
}
