<?php

namespace App\Services;

use App\Models\User;

class AutomatedCalibrationService
{
    public function evaluateEmployeePath(User $user): array
    {
        $averageAchievement = $user->goalsAndKpis()->avg('current_progress_rate') ?? 0.00;
        $negativeIncidents = $user->criticalIncidents()->where('type', 'negative')->count();
        $positiveIncidents = $user->criticalIncidents()->where('type', 'positive')->count();

        // 1. إذا كان الأداء منخفضاً وتراكمت السلوكيات السلبية
        if ($averageAchievement < 80.00 || $negativeIncidents >= 3) {
            return [
                'recommendation' => 'PIP_REQUIRED',
                'reason' => "الموظف متعثر في الأداء الفعلي (نسبة الإنجاز {$averageAchievement}%) مع رصد {$negativeIncidents} وقائع حرجة سلبية. يوصى بخطة تحسين الأداء PIP فورية.",
            ];
        }

        // 2. إذا كان الموظف متميزاً ويتجاوز التوقعات (تمكين واستبقاء)
        if ($averageAchievement >= 115.00 && $positiveIncidents >= 3) {
            return [
                'recommendation' => 'IDP_UPGRADE',
                'reason' => "أداء متميز واستثنائي (نسبة الإنجاز {$averageAchievement}%) مع رصد {$positiveIncidents} وقائع إيجابية متتالية. يوصى ببرنامج تطوير فردي IDP وتأهيل للترقية.",
            ];
        }

        return [
            'recommendation' => 'MAINTAIN_COACHING',
            'reason' => "الأداء ضمن النطاق الآمن المستهدف (نسبة الإنجاز {$averageAchievement}%). استمر في جلسات التوجيه وكوتشينج الأداء ربع السنوية.",
        ];
    }
}
