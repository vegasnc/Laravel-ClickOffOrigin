<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Status extends Authenticatable
{
    protected $connection ="mysql";

    protected $table ="status";

    protected $fillable = [
        'name',
    ];

    
}
