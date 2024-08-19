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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained('orders','id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('S_user');
            $table->string('S_national_id');
            $table->string('S_phone_number');
            $table->string('S_family_registration');
            $table->string('S_mother_name');
            $table->string('S_Location')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->string('R_user');
            $table->string('R_phone_number');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
