<?php

namespace App\Models;

use App\Enums\MenuStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major_Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'major_categories';

    protected $fillable = [
        "name",
        "slug",
        "status"
    ];

    const MENU_STATUS = [
        'SHOW' => 'show',
        'HOT_DEFAULT' => 'hot_default',
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

    public function categories()
    {
        return $this->hasMany(Category::class, 'major_category_id');
    }

    public function slide()
    {
        return $this->hasMany(Slide::class, 'major_category_id');
    }

    public function getStatusNameAttribute()
    {
        return strtolower(MenuStatusEnum::getKeys($this->status)[0]);
    }
}
