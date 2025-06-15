<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbItineraryCulinaryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_Itinerary_Culinary', function (Blueprint $table) {
            $table->id();
            $table->string('list_id', 11);
            $table->string('culinary_id', 11);
            $table->timestamps();

            // Indexes
            $table->index('list_id');
            $table->index('culinary_id');

            // Foreign keys
            $table->foreign('list_id')
                  ->references('list_id')
                  ->on('tb_Itinerary')
                  ->onDelete('cascade');

            $table->foreign('culinary_id')
                  ->references('culinary_id')
                  ->on('tb_Culinary')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_Itinerary_Culinary');
    }
}
