<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory;
    use SoftDeletes;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $fillable = [
        'email',
        'username',
        'fullname',
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

    public function getAgeAttribute()
    {
        return date_diff(date_create($this->birthday), date_create())->y;
    }

    public function getRoleNameAttribute()
    {
        return strtolower(UserRoleEnum::getKeys($this->level)[0]);
    }

    public function getGenderNameAttribute()
    {
        return ($this->gender == 0) ? 'Male' : 'Female';
    }

    public function getStatusNameAttribute()
    {
        return ($this->status == 1) ? 'Active' : 'Not active';
    }

}
