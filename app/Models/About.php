<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'abouts';

    protected $fillable = [
        "title",
        "phone",
        "phone_second",
        "email",
        "logo",
        "address",
        "address_second",
        "link_address_fb",
        "link_address_youtube",
        "link_address_zalo",
        "link_address_instagram",
    ];
}
