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
        Schema::table('patients', function (Blueprint $table) {
            // الرصيد الحالي للمريض (مبلغ مستحق)
            $table->decimal('balance', 10, 2)->default(0)->after('address');

            // إجمالي المبالغ المدفوعة
            $table->decimal('total_paid', 10, 2)->default(0)->after('balance');

            // الحد الائتماني للمريض
            $table->decimal('credit_limit', 10, 2)->default(0)->after('total_paid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['balance', 'total_paid', 'credit_limit']);
        });
    }
};
