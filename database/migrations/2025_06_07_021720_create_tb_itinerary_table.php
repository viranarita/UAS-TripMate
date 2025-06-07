<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTbItineraryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_Itinerary', function (Blueprint $table) {
            $table->integer('list_id')->primary();
            $table->integer('user_id');
            $table->string('list_name', 150);
            $table->date('departure_date');
            $table->date('return_date');

            // trip_days tidak bisa langsung pakai GENERATED di Laravel, jadi kita siapkan kolom biasa
            $table->integer('trip_days')->storedAs('TO_DAYS(return_date) - TO_DAYS(departure_date)');

            $table->enum('departure_city', ['Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta']);
            $table->enum('destination_city', ['Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta']);

            // Kolom timestamp dengan default current timestamp dan auto-update
            $table->timestamp('timestamp')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_Itinerary');
    }
}
