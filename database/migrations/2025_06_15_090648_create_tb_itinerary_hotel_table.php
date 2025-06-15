<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbItineraryHotelTable extends Migration
{
    public function up(): void
    {
        Schema::create('tb_Itinerary_Hotel', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedInteger('list_id'); // Foreign key ke itinerary
            $table->string('hotel_id', 11); // Foreign key ke hotel

            // Foreign key constraint
            $table->foreign('list_id')->references('list_id')->on('tb_Itinerary')->onDelete('cascade');
            $table->foreign('hotel_id')->references('hotel_id')->on('tb_Hotels')->onDelete('cascade');

            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_Itinerary_Hotel');
    }
}
