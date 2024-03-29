<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class Customer extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

    protected $fillable = [
        "name",
        "email",
        "password",
        "phone",
        "address",
        "status",
        "token",
    ];

    const CUSTOMER_STATUS = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
        'PENDING' => 'pending',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'customer_id', 'id');
    }

    public function getStatusNameAttribute()
    {
        return ($this->status == 1) ? 'Active' : 'Blocked';
    }
}
