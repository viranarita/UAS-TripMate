<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    protected $table = 'tb_Packages';
    protected $primaryKey = 'package_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'package_id',
        'name',
        'details',
        'price',
        'city',
        'days',
        'nights',
        'departure_date',
    ];
}
