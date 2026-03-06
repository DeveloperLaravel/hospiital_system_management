<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * إضافة حقلي الأعراض والعلامات الحيوية لجدول السجلات الطبية
     */
    public function up(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            // الأعراض
            $table->text('symptoms')
                ->nullable()
                ->after('diagnosis');

            // العلامات الحيوية
            $table->string('vital_signs', 500)
                ->nullable()
                ->after('symptoms');
        });
    }

    /**
     * rollback
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn(['symptoms', 'vital_signs']);
        });
    }
};
