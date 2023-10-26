<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory, SoftDeletes;


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

    const ATTRIBUTE_STATUS = [
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

    public function attribute_values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id');
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
