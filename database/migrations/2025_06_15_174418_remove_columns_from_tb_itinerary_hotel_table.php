<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromTbItineraryHotelTable extends Migration
{
    public function up()
    {
        Schema::table('tb_Itinerary_Hotel', function (Blueprint $table) {
            $table->dropColumn(['nights', 'total_price', 'room_count']);
        });
    }

    public function down()
    {
        Schema::table('tb_Itinerary_Hotel', function (Blueprint $table) {
            $table->integer('nights')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->integer('room_count')->nullable();
        });
    }
}
