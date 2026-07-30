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
        Schema::create('critical_incident_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // الموظف المرصود
            $table->foreignId('reporter_id')->constrained('users'); // الكوتش الراصد للواقعة
            $table->date('incident_date');
            $table->text('observed_situation'); // الموقف المشاهد (Situation)
            $table->text('actual_behavior'); // السلوك الفعلي (Behavior)
            $table->text('result_impact'); // الأثر الناتج (Impact)
            $table->enum('type', ['positive', 'negative']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('critical_incident_logs');
    }
};
