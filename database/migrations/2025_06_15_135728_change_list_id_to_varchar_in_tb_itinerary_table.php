<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeListIdToVarcharInTbItineraryTable extends Migration
{
    public function up(): void
    {
        Schema::table('tb_Itinerary', function (Blueprint $table) {
            $table->string('list_id', 11)->change();
        });
    }

    public function down(): void
    {
        Schema::table('tb_Itinerary', function (Blueprint $table) {
            $table->integer('list_id')->change(); // ubah kembali jadi integer jika di-rollback
        });
    }
}
