<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'tb_Hotels';
    protected $primaryKey = 'hotel_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'hotel_id',
        'name',
        'location',
        'price_per_night',
        'image_url',
    ];
}
