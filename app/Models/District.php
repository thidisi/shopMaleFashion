<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';

    protected $fillable = [
        'id',
        'province_id',
        'name',
        'slug'
    ];

    public $timestamps = false;

    public function provinces()
    {
        return $this->belongsTo(Province::class);
    }

    public function wards()
    {
        return $this->hasMany(Ward::class, 'district_id', 'id');
    }
}
