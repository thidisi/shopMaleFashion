<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;
    use SoftDeletes;

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


    public function attributes()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function productions()
    {
        return $this->belongsToMany(Production::class, 'production_attr_value', 'production_id', 'attribute_value_id');
    }

    public function getStatusNameAttribute()
    {
        return ($this->status == 1) ? "Active" : "Not active";
    }
}
