<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePackagesAddDaysNightsColumns extends Migration
{
    public function up()
    {
        Schema::table('tb_Packages', function (Blueprint $table) {
            $table->integer('days')->after('city')->nullable();
            $table->integer('nights')->after('days')->nullable();
            $table->dropColumn('duration'); // hapus kolom duration lama
        });
    }

    public function down()
    {
        Schema::table('tb_Packages', function (Blueprint $table) {
            $table->dropColumn(['days', 'nights']);
            $table->integer('duration')->nullable(); // bisa diubah ke sesuai default awal
        });
    }
}
