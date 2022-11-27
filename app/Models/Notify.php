<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use HasFactory;
    protected $table = 'notifies';

    protected $fillable = [
        'title',
        'type',
        'products',
        'discounts',
        'orders',
        'tickets',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'discounts' => 'array',
        'products' => 'array',
        'orders' => 'array',
        'tickets' => 'array',
    ];
}
