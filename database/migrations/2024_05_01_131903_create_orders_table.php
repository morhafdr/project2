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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('total_price')->nullable();
            $table->string('payment_method');
            $table->string('payment_type');
             $table->enum('status', ['قيد الجلب','جاري المعالجة','مكتمل'])->default('قيد الجلب');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users','id')
               ;
          $table->foreignId('from_office_id')
                ->constrained('offices','id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('to_office_id')
                ->constrained('offices','id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('employee_id')
                 ->nullable()
                ->constrained('employees','id')
                ;
           $table->foreignId('customer_id')
                ->nullable()
                ->constrained('customers','id')
                       ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
