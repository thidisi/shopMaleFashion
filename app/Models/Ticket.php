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
        'customer_id',
        'price',
        'date_end',
        'status',
    ];

    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }
}
