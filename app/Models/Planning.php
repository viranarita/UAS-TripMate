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
        'image',
    ];

    // Relasi ke user (jika diperlukan)
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function culinaries()
    {
        return $this->belongsToMany(Culinary::class, 'tb_Itinerary_Culinary', 'list_id', 'culinary_id');
    }

}
