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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                ->constrained('orders','id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('office_id')
                ->constrained('offices','id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('incoming_good_id')->nullable()
                ->constrained('incoming_goods','id');
            $table->foreignId('outdoing_good_id')->nullable()
                ->constrained('outdoing_goods','id');
            $table->enum('status', ['Pending','Completed']);
            $table->decimal('value');
            $table->string('payment_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('send_invoices');
    }
};
