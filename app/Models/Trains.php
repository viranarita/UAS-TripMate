<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trains extends Model
{
    protected $table = 'tb_Trains';
    protected $primaryKey = 'train_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'train_id',
        'train_name',
        'train_type',
        'departure_time',
        'arrival_time',
        'origin',
        'destination',
        'price',
    ];
}
