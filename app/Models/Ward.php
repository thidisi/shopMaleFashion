<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $table = 'wards';

    protected $fillable = [
        'id',
        'district_id',
        'name',
        'slug',
        'path'
    ];

    public $timestamps = false;

    public function districts()
    {
        return $this->belongsTo(District::class);
    }
}
