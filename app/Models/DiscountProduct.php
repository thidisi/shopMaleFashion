<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DiscountProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'discount_product';

    protected $fillable = [
        "production_id",
        "discount_id",
        "status",
    ];

    public function discounts()
    {
        return $this->belongsTo(Discount::class);
    }

    public function productions()
    {
        return $this->belongsTo(Production::class);
    }

    public function getStatusNameAttribute()
    {
        return ($this->status == 1) ? "Active" : "Not active";
    }
}
