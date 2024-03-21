<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;


class User extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable;
    use DisplayableValueTrait;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;


    protected $fillable = [
        'name',
        'email',
        'password',
        'user_admin_privilege',
        'user_gender',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function isAdmin()
    {
        return $this->user_admin_privilege;
    }
    public function getAdminStatusAttribute()
    {
        return $this->user_admin_privilege ? 'Yes' : 'No';
    }

    public function workout() {
        return $this->hasOne('App\Models\Workout', 'user_id');
    }
}
