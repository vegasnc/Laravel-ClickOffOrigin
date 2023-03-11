<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Action extends Authenticatable
{
    protected $connection ="mysql";

    protected $table ="action";

    protected $fillable = [
        'name',
    ];

    
}
