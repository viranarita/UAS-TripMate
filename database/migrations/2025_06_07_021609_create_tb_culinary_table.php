<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbCulinaryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_Culinary', function (Blueprint $table) {
            $table->string('culinary_id', 11)->primary();
            $table->string('name', 255);
            $table->string('location', 255);
            $table->enum('price_range', ['Murah', 'Sedang', 'Mahal']);
            $table->binary('image_url')->nullable(); // longblob dengan default null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_Culinary');
    }
}
