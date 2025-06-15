<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbItineraryBusesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_Itinerary_Buses', function (Blueprint $table) {
            $table->id();
            $table->string('list_id', 11);
            $table->string('bus_id', 11);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('list_id')
                  ->references('list_id')
                  ->on('tb_Itinerary')
                  ->onDelete('cascade');

            $table->foreign('bus_id')
                  ->references('bus_id')
                  ->on('tb_Buses')
                  ->onDelete('cascade');

            // Indexes
            $table->index('list_id');
            $table->index('bus_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_Itinerary_Buses');
    }
}
