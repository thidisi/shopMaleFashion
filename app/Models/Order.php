<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    protected $fillable = [
        "customer_id",
        "name_receiver",
        "phone_receiver",
        "address_receiver",
        "total_money",
        "ticket_id",
        "note",
        "action",
    ];

    const ORDER_STATUS = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
        'PENDING' => 'pending',
    ];

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function tickets()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function productions()
    {
        return $this->belongsToMany(Production::class, 'order_detail', 'order_id', 'production_id')
        ->withPivot('quantity')
        ->withPivot('attr')
        ->withTimestamps();
    }
}
