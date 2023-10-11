<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $fillable = [
        'email',
        'username',
        'password',
        'address',
        'phone',
        'birthday',
        'avatar',
        'gender',
        'level',
        'status',
        'last_login'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    const USER_GENDER = [
        'Male' => 'male',
        'Female' => 'female',
    ];

    const USER_STATUS = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
        'PENDING' => 'pending',
    ];

    const USER_LEVEL = [
        'STAFF' => 'staff',
        'MANAGER' => 'manager',
        'ADMIN' => 'admin',
    ];

    public $timestamps = true;

    /**
     * Return the created_at configuration array for this model.
     *
     * @return array
     */
    protected $casts = [
        'created_at' => 'date:d-m-Y',
        'updated_at' => 'date:d-m-Y'
    ];

    public function getAgeAttribute()
    {
        return date_diff(date_create($this->birthday), date_create())->y;
    }
}
