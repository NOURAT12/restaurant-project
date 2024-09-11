<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tabels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rustaurant_id')->constrained('rusturants')->onDelete('cascade');
            $table->float('table_number');
            $table->float('floor_number');
            $table->float('chairs_number');
            $table->double('state');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabels');
    }
};
