<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbItineraryCulinaryTable extends Migration
{
    public function up(): void
    {
        Schema::create('tb_Itinerary_Culinary', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedInteger('list_id'); // Foreign key ke itinerary
            $table->string('culinary_id', 11); // Foreign key ke culinary

            // Foreign key constraint
            $table->foreign('list_id')->references('list_id')->on('tb_Itinerary')->onDelete('cascade');
            $table->foreign('culinary_id')->references('culinary_id')->on('tb_Culinary')->onDelete('cascade');

            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_Itinerary_Culinary');
    }
}
