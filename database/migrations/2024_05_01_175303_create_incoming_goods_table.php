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
        Schema::create('incoming_goods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')
                ->constrained('warehouses','id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('order_id')
                ->constrained('orders','id')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('good_name');
            $table->integer('quantity');
            $table->string('price')->nullable();
            $table->enum('weight', ['under_5', 'under_20', 'under_40', 'under_60']);
            $table->string('status');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_goods');
    }
};
