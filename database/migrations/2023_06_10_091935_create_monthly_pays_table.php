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
        Schema::create('monthly_pays', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_paid');
            $table->float('cost');
            $table->foreignId('rustaurant_id')->constrained('rusturants');
            $table->date('end');
            $table->date('start');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_pays');
    }
};
