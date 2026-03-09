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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('shift_name');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('shift_type', ['morning', 'evening', 'night', 'day_off', 'on_call'])->default('morning');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->string('assigned_type')->nullable(); // 'App\Models\Doctor' or 'App\Models\Nurse'
            $table->date('date');
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled', 'absent'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
