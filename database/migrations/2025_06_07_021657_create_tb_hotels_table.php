<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbHotelsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_Hotels', function (Blueprint $table) {
            $table->string('hotel_id', 11)->primary();
            $table->string('name', 255);
            $table->string('location', 255);
            $table->decimal('price_per_night', 10, 2);
            $table->binary('image_url'); // longblob
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_Hotels');
    }
}
