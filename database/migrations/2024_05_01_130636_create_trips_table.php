<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new



class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_id')
                ->constrained('trucks','id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('from_office_id')
                ->constrained('offices','id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('distancePerKm');
            $table->enum('status', [ 'جاهز','مرسل' ,'مستلم'])->nullable();
            $table->foreignId('to_office_id')
                ->constrained('offices','id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
