<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    protected $table = 'tb_Attractions';
    protected $primaryKey = 'attraction_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['attraction_id', 'name', 'location', 'price', 'image_url'];
}
