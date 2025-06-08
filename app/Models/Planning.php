<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    protected $table = 'tb_Itinerary';
    protected $primaryKey = 'list_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'list_name',
        'departure_date',
        'return_date',
        'departure_city',
        'destination_city',
    ];

    // Relasi ke user (jika diperlukan)
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
