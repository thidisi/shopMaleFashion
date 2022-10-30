<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'provinces';

    protected $fillable = [
        'id',
        'name',
        'slug'
    ];

    public $timestamps = false;

    public function districts()
    {
        return $this->hasMany(District::class, 'province_id', 'id');
    }
}
