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
        Schema::create('performance_improvement_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('gap_description');
            $table->text('strict_targets');
            $table->text('management_support');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'successful', 'unsuccessful'])->default('active');
            $table->boolean('employee_signed')->default(false);
            $table->boolean('manager_signed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_improvement_plans');
    }
};
