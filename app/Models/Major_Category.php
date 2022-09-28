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
        "status"
    ];

    public function categories()
    {
        return $this->hasMany(Category::class, 'major_category_id', 'id');
    }

    public function slide()
    {
        return $this->hasMany(Slide::class, 'major_category_id', 'id');
    }

    public function getStatusNameAttribute()
    {
        return strtolower(MenuStatusEnum::getKeys($this->status)[0]);
    }
}
