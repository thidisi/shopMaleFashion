<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function parents()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
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
