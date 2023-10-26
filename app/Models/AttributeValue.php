<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attribute_values';

    protected $fillable = [
        "attribute_id",
        "name",
        "slug",
        "descriptions",
        "status",
    ];

    const ATTRIBUTE_VALUE_STATUS = [
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

    public function attributes()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function productions()
    {
        return $this->belongsToMany(Production::class, 'production_attr_value', 'production_id', 'attribute_value_id')->withTimestamps();
    }

    public function getStatusNameAttribute()
    {
        return ($this->status == 1) ? "Active" : "Not active";
    }
}
