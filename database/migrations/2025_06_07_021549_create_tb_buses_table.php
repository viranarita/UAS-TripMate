<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbBusesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_Buses', function (Blueprint $table) {
            $table->string('bus_id', 11)->primary();
            $table->string('bus_name', 255);
            $table->enum('bus_class', ['VIP', 'Eksekutif', 'Ekonomi']);
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
        Schema::dropIfExists('tb_Buses');
    }
}
