<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('tb_Itinerary_Culinary');
        Schema::dropIfExists('tb_Itinerary_Hotel');
        Schema::dropIfExists('tb_Itinerary_Attractions');
    }

    public function down(): void
    {
        //
    }
};
