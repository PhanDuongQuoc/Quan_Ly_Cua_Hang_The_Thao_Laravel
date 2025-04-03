<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'users'; // Chỉ định bảng trung gian
    protected $fillable = [
        'full_name', 'email', 'password', 'remember_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

  
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles'); 
    }
    

    public function hasRole($roleName) {
        return $this->roles()->where('name', $roleName)->exists();
    }


    
}
