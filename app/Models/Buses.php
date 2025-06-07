<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buses extends Model
{
    protected $table = 'tb_Buses';
    protected $primaryKey = 'bus_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'bus_id',
        'bus_name',
        'bus_class',
        'departure_time',
        'arrival_time',
        'origin',
        'destination',
        'price',
    ];
}
