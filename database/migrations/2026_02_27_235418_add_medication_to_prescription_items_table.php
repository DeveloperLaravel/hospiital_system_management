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
        Schema::table('prescription_items', function (Blueprint $table) {
            // إضافة العمود مع المفتاح الأجنبي
            $table->foreignId('medication_id')
                ->constrained('medications')
                ->cascadeOnDelete()
                ->after('prescription_id'); // يفضل وضعه بعد prescription_id

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescription_items', function (Blueprint $table) {
            //
        });
    }
};
