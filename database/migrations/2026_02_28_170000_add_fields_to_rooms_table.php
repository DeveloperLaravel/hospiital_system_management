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
        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('floor')->default(1)->after('status');
            $table->integer('beds_count')->default(1)->after('floor');
            $table->decimal('price', 10, 2)->default(0)->after('beds_count');
            $table->text('notes')->nullable()->after('price');
            $table->enum('status', ['available', 'occupied', 'maintenance', 'cleaning'])->default('available')->change();
            $table->enum('type', ['single', 'double', 'icu', 'vip', 'emergency'])->default('single')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['floor', 'beds_count', 'price', 'notes']);
            $table->enum('status', ['available', 'occupied'])->default('available')->change();
            $table->enum('type', ['single', 'double', 'ICU'])->default('single')->change();
        });
    }
};
