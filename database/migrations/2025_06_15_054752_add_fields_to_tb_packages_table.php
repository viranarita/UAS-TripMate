<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tb_Packages', function (Blueprint $table) {
            $table->string('city')->after('price');
            $table->integer('days')->after('city');
            $table->integer('nights')->after('days');
            $table->date('departure_date')->after('nights');
        });
    }

    public function down()
    {
        Schema::table('tb_Packages', function (Blueprint $table) {
            $table->dropColumn(['city', 'days', 'nights', 'departure_date']);
        });
    }
};
