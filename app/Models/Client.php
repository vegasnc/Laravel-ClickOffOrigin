<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    protected $connection ="mysql";

    protected $table ="client";

    protected $fillable = [
        'name',
    ];

    
}
