<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'productions';

    protected $fillable = [
        "name",
        "category_id",
        "price",
        "quantity",
        "slug",
        "descriptions",
        "count_view",
        "status",
    ];

    const PRODUCTION_STATUS = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function product_images()
    {
        return $this->hasOne(ProductImage::class, 'production_id');
    }

    public function discount_products()
    {
        return $this->hasOne(DiscountProduct::class, 'production_id');
    }

    public function attribute_values()
    {
        return $this->belongsToMany(AttributeValue::class, 'production_attr_value', 'production_id', 'attribute_value_id')->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_detail', 'order_id', 'production_id')
        ->withPivot('quantity')
        ->withPivot('attr')
        ->withTimestamps();
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'production_comments', 'comment_id', 'production_id')
        ->withPivot('review')
        ->withTimestamps();
    }

    public function getStatusNameAttribute()
    {
        return ($this->status == 1) ? "Active" : "Not active";
    }

}
