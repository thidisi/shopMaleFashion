<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_images';

    protected $fillable = [
        "production_id",
        "image",
        "type_image",
        "status",
    ];

    const PRODUCT_IMAGE_STATUS = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
    ];


    public function productions()
    {
        return $this->belongsTo(Production::class);
    }

    public function getStatusNameAttribute()
    {
        return ($this->status == 1) ? "Active" : "Not active";
    }
}
