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
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('appointment_type')->nullable()->default('checkup')->after('notes');
            $table->boolean('is_emergency')->nullable()->default(false)->after('appointment_type');
            $table->integer('duration')->nullable()->default(30)->after('is_emergency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['appointment_type', 'is_emergency', 'duration']);
        });
    }
};
