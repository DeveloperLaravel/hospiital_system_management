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
        Schema::table('medicine_transactions', function (Blueprint $table) {
            $table->string('reference_number')->nullable()->after('quantity');
            $table->text('notes')->nullable()->after('reference_number');
            $table->string('transaction_date')->nullable()->after('notes');
            $table->foreignId('prescription_id')->nullable()->constrained()->nullOnDelete()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicine_transactions', function (Blueprint $table) {
            $table->dropForeign(['prescription_id']);
            $table->dropColumn(['reference_number', 'notes', 'transaction_date', 'prescription_id']);
        });
    }
};
