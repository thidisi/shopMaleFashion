<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blogs';

    protected $fillable = [
        "title",
        "content",
        "image",
        "count_view",
        "status"
    ];

    public function getFormatDateAttribute()
    {
        return date("d-M-Y", strtotime($this->created_at)) . "\n";
    }
}
