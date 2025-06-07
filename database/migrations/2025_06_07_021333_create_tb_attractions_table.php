<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbAttractionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_Attractions', function (Blueprint $table) {
            $table->string('attraction_id', 11)->primary();
            $table->string('name', 255);
            $table->string('location', 255);
            $table->decimal('price', 10, 2)->nullable();
            $table->binary('image_url'); // untuk longblob
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_Attractions');
    }
}
