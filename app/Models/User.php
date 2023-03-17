<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    protected $hidden = ['password'];
    protected $fillable = ['name', 'email', 'password', 'roles'];

    public function scopeListing($q)
    {
        $q
            ->select([
                'users.name', 'users.email'
            ]);
    }
}
