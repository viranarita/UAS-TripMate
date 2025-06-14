<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCityAndDurationToTbPackagesTable extends Migration
{
    public function up()
    {
        Schema::table('tb_Packages', function (Blueprint $table) {
            $table->string('city')->after('name');
            $table->string('duration')->after('city');
        });
    }

    public function down()
    {
        Schema::table('tb_Packages', function (Blueprint $table) {
            $table->dropColumn(['city', 'duration']);
        });
    }
}
