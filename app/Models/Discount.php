<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'discounts';

    protected $fillable = [
        "date_start",
        "date_end",
        "discount_price",
    ];

    public function discount_product()
    {
        return $this->hasMany(DiscountProduct::class, 'discount_id', 'id');
    }

    public function getFormatDateStartAttribute()
    {
        return date("d-M-Y", strtotime($this->date_start)) . "\n";
    }

    public function getFormatDateEndAttribute()
    {
        return date("d-M-Y", strtotime($this->date_end)) . "\n";
    }

    public function getDateTimeAttribute()
    {
        return date("F d, Y H:i:s", strtotime($this->date_end));
    }
}
