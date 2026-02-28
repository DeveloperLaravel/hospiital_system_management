<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * إنشاء جدول السجلات الطبية
     */
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {

            $table->id();

            // المريض
            $table->foreignId('patient_id')
                ->constrained()
                ->cascadeOnDelete();

            // الطبيب
            $table->foreignId('doctor_id')
                ->constrained()
                ->cascadeOnDelete();

            // الموعد المرتبط بالسجل (اختياري)
            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained('appointments')
                ->nullOnDelete();

            // تاريخ الزيارة
            $table->date('visit_date')
                ->nullable();

            // التشخيص
            $table->text('diagnosis')
                ->nullable();

            // العلاج
            $table->text('treatment')
                ->nullable();

            // ملاحظات إضافية
            $table->text('notes')
                ->nullable();

            $table->timestamps();

            // فهارس لتحسين الأداء
            $table->index(['patient_id', 'doctor_id']);
            $table->index('visit_date');
        });
    }

    /**
     * حذف الجدول بالكامل عند rollback
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
