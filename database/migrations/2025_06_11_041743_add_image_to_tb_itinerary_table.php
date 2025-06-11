<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `tb_Itinerary` ADD `image` LONGBLOB NULL AFTER `destination_city`");
    }

    public function down(): void
    {
        Schema::table('tb_Itinerary', function ($table) {
            $table->dropColumn('image');
        });
    }
};
