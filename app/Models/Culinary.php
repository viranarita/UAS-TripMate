<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Culinary extends Model
{
    use HasFactory;

    protected $table = 'tb_Culinary';
    protected $primaryKey = 'culinary_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'culinary_id',
        'name',
        'location',
        'price_range',
        'image_url',
    ];

    public function itineraries()
    {
        return $this->belongsToMany(Planning::class, 'tb_Itinerary_Culinary', 'culinary_id', 'list_id');
    }

}
