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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();

            // المعلومات الأساسية
            $table->string('name');
            $table->string('type')->nullable();
            $table->text('description')->nullable();

            // المخزون
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('min_stock')->default(10);

            // السعر
            $table->decimal('price', 8, 2)->default(0);

            // التتبع
            $table->string('barcode')->unique()->nullable();
            $table->string('qr_code')->unique()->nullable();

            // السلامة
            $table->date('expiry_date')->nullable();

            // الحالة
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
