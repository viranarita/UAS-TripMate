<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Pastikan semua nilai NULL diisi dulu
        DB::statement("UPDATE `tb_Itinerary` SET `image` = '' WHERE `image` IS NULL");

        // Step 2: Ubah kolom jadi NOT NULL
        DB::statement("ALTER TABLE `tb_Itinerary` MODIFY `image` LONGBLOB NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `tb_Itinerary` MODIFY `image` LONGBLOB NULL");
    }
};
