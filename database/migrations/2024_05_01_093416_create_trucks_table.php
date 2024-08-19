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
        Schema::create('trucks', function (Blueprint $table)
        {
            $table->id();
            $table->string('plate_number');
            $table->foreignId('driver_id')
            ->constrained('drivers','id')
            ->cascadeOnUpdate();
            $table->string('type');
            $table->integer('capacity');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }

};
