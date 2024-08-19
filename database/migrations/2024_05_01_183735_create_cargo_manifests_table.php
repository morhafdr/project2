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
        Schema::create('cargo_manifests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')
                ->constrained('trips','id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('incoming_good_id')
                ->constrained('incoming_goods','id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo_manifests');
    }
};
