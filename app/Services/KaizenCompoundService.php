<?php

namespace App\Services;

class KaizenCompoundService
{
    /**
     * حساب التراكم الإيجابي والسلبي للموظف
     * (1.01)^365 = 37.78 (تحسن متراكم)
     * (0.99)^365 = 0.03 (تراجع نحو الصفر تقريباً)
     */
    public function getKaizenProjections(float $dailyImprovementRate = 0.01, int $days = 365): array
    {
        $positiveMultiplier = pow(1 + $dailyImprovementRate, $days); // (1.01)^365
        $negativeDecline = pow(1 - $dailyImprovementRate, $days); // (0.99)^365

        return [
            'improvement_factor' => round($positiveMultiplier, 2), // 37.78 ضعفاً بنهاية العام
            'decline_floor' => round($negativeDecline, 2), // 0.03 (تراجع للصفر تقريباً)
        ];
    }
}
