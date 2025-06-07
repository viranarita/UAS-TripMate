<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flights extends Model
{
    protected $table = 'tb_Flights';
    protected $primaryKey = 'flight_id';
    public $incrementing = false;
    public $timestamps = false;


    protected $fillable = [
        'flight_id',
        'airline', 
        'departure_time', 
        'arrival_time', 
        'origin', 
        'destination', 
        'price'
    ];
}
