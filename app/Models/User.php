<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    
    protected $table = 'usuarios';
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthdate',
        'active'
    ];

    public function scopeOrder($query)
    {
        return $query->orderBy('name');
    }
}
