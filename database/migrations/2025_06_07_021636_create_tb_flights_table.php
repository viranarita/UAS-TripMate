<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFlightsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_Flights', function (Blueprint $table) {
            $table->string('flight_id', 11)->primary();
            $table->string('airline', 255);
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->string('origin', 100);
            $table->string('destination', 100);
            $table->decimal('price', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_Flights');
    }
}
