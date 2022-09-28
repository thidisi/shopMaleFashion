<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attributes';

    protected $fillable = [
        "name",
        "slug",
        "descriptions",
        "status",
        "replace_id",
    ];

    public function attribute_values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id', 'id');
    }

    public function replaces()
    {
        return $this->hasMany(self::class, 'replace_id', 'id');
    }

    public function getStatusNameAttribute()
    {
        return ($this->status == 1) ? "Active" : "Not active";
    }
}
