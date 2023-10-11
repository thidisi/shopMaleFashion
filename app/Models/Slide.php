<?php

namespace App\Models;

use App\Enums\SortOrderSlideEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slide extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'slide';

    protected $fillable = [
        "name",
        "title",
        "slug",
        "image",
        "major_category_id",
        "sort_order",
        "status",
    ];

    const SLIDE_STATUS = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
    ];

    const SLIDE_ORDER = [
        'SLIDER' => 'slider',
        'INSTAGRAM' => 'instagram',
        'BANNER' => 'banner',
        'HIDE' => 'hide',
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

    public function getSortOrderNameAttribute()
    {
        return strtolower(SortOrderSlideEnum::getKeys($this->sort_order)[0]);
    }

    public function getStatusNameAttribute()
    {
        return ($this->status == 1) ? "Active" : "Not active";
    }

    public function major_categories()
    {
        return $this->belongsTo(Major_Category::class, 'major_category_id');
    }
}
