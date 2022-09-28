<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function major_categories()
    {
        return $this->belongsTo(Major_Category::class);
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
