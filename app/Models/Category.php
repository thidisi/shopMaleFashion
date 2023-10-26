<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    protected $fillable = [
        "name",
        "slug",
        "avatar",
        "status",
        "major_category_id",
    ];

    const CATEGORY_STATUS = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
    ];

    public $timestamps = true;

    /**
     * Return the created_at configuration array for this model.
     *
     * @return array
     */
    protected $casts = [
        'created_at' => 'date:d-m-Y',
        'updated_at' => 'date:d-m-Y'
    ];

    public function major_categories()
    {
        return $this->belongsTo(Major_Category::class, 'major_category_id');
    }

    public function productions()
    {
        return $this->hasMany(Production::class, 'category_id', 'id');
    }

    public function getStatusNameAttribute()
    {
        return ($this->status == 1) ? "Active" : "Not active";
    }
}
