<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admins extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guard = 'admins';

        protected $fillable = [
            'username', 'password',
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];
}
