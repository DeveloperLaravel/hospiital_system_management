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
            // رقم الفاتورة
            $table->string('invoice_number')->unique();

            // المريض
            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            // المبلغ
            $table->decimal('total', 10, 2)->default(0);

            // الحالة
            $table->enum('status', [
                'draft',
                'unpaid',
                'paid',
                'cancelled',
            ])->default('draft');

            // تاريخ الفاتورة
            $table->date('invoice_date')->now();

            // ملاحظات
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
