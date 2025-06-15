<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tb_Itinerary', function (Blueprint $table) {
            $table->binary('image')->nullable();
        });
        
    }

    public function down()
    {
        Schema::table('tb_Itinerary', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
