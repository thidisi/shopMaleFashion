<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';

    protected $fillable = [
        "customer_id",
        "content",
        "status",
        "parent_id",
    ];
    const COMMENT_STATUS = [
        'ACTIVE' => 'active',
        'INACTIVE' => 'inactive',
        'PENDING' => 'pending',
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

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
    public function parents()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function productions()
    {
        return $this->belongsToMany(Production::class, 'production_comments', 'comment_id', 'production_id')
            ->withPivot('review')
            ->withPivot('images')
            ->withTimestamps();
    }

    public function getStatusNameAttribute()
    {
        return ($this->status == 1) ? "Active" : "Not active";
    }
}
