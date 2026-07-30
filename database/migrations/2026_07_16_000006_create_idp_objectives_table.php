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
        Schema::create('idp_objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idp_id')->constrained('individual_development_plans')->onDelete('cascade');
            $table->string('development_area');
            $table->enum('learning_type', ['experiential', 'exposure', 'formal'])->default('experiential');
            $table->string('scheduling_type')->default('range'); // 'range' or 'specific'
            $table->integer('start_month')->nullable();
            $table->integer('end_month')->nullable();
            $table->json('specific_months')->nullable();
            $table->text('action_steps');
            $table->string('measure_of_success');
            $table->text('support_needed');
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idp_objectives');
    }
};
