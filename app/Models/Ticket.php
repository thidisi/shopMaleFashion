<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    const TICKET_STATUS = [
        'OPEN'            => 'pending',
        'PAYMENT_SUCCESS' => 'active',
        'CLOSE'           => 'suspended',
    ];

    protected $fillable = [
        'data_customer',
        'price',
        'date_end',
        'code',
        'quantity',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'data_customer' => 'array',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'ticket_id');
    }

    public function getFormatDateEndAttribute()
    {
        return date("d-M-Y", strtotime($this->date_end)) . "\n";
    }
}
