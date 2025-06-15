<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbItineraryTrainsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_Itinerary_Trains', function (Blueprint $table) {
            $table->id();
            $table->string('list_id', 11);
            $table->string('train_id', 11);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('list_id')
                  ->references('list_id')
                  ->on('tb_Itinerary')
                  ->onDelete('cascade');

            $table->foreign('train_id')
                  ->references('train_id')
                  ->on('tb_Trains')
                  ->onDelete('cascade');

            // Indexes
            $table->index('list_id');
            $table->index('train_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_Itinerary_Trains');
    }
}
