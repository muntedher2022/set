<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\CriticalIncidentLog;
use App\Models\PerformanceImprovementPlan;
use App\Models\IndividualDevelopmentPlan;
use App\Services\KaizenCompoundService;

class PerformancePulseWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $kaizen = app(KaizenCompoundService::class)->getKaizenProjections();

        return [
            Stat::make('الوقائع الحرجة المرصودة هذا الشهر', CriticalIncidentLog::whereMonth('created_at', now()->month)->count())
                ->description('التوثيق اللحظي يمنع النزاعات الشخصية والتحيزات نهاية السنة')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('success'),

            Stat::make('مضاعف تحسن كايزن المتوقع', "{$kaizen['improvement_factor']} ضعفاً")
                ->description('الأثر التراكمي لـ 1% تحسين ميكروسكوبي يومي بعد 365 يوم')
                ->descriptionIcon('heroicon-m-bolt')
                ->color('warning'),

            Stat::make('خطط تحسين الأداء PIP النشطة', PerformanceImprovementPlan::where('status', 'active')->count())
                ->description('دعم وتأهيل الكوادر وتصحيح الفجوات التشغيلية')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),

            Stat::make('الكوادر الواعدة في برامج IDP', IndividualDevelopmentPlan::where('status', 'active')->count())
                ->description('توطين المهارات والتحضير الفعلي للصف القيادي الثاني')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('primary'),
        ];
    }
}
