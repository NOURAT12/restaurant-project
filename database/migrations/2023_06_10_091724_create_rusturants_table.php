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
        Schema::create('rusturants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('table_number')->nullable();
            $table->foreignId('manager_id')->constrained('users')->onUpdate('cascade');
            $table->foreignId('service_id')->constrained('services')->onUpdate('cascade');
            $table->text('location');
            $table->double('status');
            $table->string('phone');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rusturants');
    }
};
