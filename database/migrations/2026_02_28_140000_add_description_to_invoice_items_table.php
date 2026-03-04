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
        Schema::table('invoice_items', function (Blueprint $table) {
            // إضافة عمود الوصف
            if (! Schema::hasColumn('invoice_items', 'description')) {
                $table->text('description')->nullable()->after('name');
            }

            // إعادة تسمية name إلى service إذا كانت موجودة
            if (Schema::hasColumn('invoice_items', 'name')) {
                $table->renameColumn('name', 'service');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->renameColumn('service', 'name');
            $table->dropColumn('description');
        });
    }
};
