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
        Schema::create('goals_and_kpis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('perspective', ['learning_growth', 'internal_processes', 'customer', 'financial_strategic']);
            $table->text('smart_goal_text'); // صياغة الهدف ذكياً (SMART)
            $table->decimal('weight', 5, 2)->default(10.00); // الوزن النسبي (10% - 30%)
            $table->decimal('baseline', 10, 2)->default(0.00); // خط الأساس للأعوام السابقة
            $table->decimal('target', 10, 2); // المستهدف السنوي المتمدد
            $table->decimal('current_progress_rate', 10, 2)->default(0.00); // نسبة الإنجاز الفعلي الحالية
            $table->enum('kpi_type', ['leading', 'lagging']); // نوع المؤشر
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals_and_kpis');
    }
};
