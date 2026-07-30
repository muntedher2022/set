<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\User;

class NineBoxCalibration extends Page
{
    protected string $view = 'filament.pages.nine-box-calibration';
    
    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin() || auth()->user()->isCoach();
    }
    
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';
    
    protected static ?string $navigationLabel = 'معايرة الأداء (9-Box Grid)';
    
    protected static ?string $title = 'مصفوفة المربعات التسعة لمعايرة الأداء';
    
    public array $grid = [];

    public function mount()
    {
        $this->calculateGrid();
    }

    public function calculateGrid()
    {
        // Initialize the 9 boxes
        $boxes = [
            'high_performance' => [
                'low_potential' => [
                    'title' => 'موظف تقني أساسي (حامي العمليات اليومية)',
                    'description' => 'أداء متميز ولكن شغف/إمكانيات نمو منخفضة. ركز على استقراره ونقل معرفته للآخرين.',
                    'color_class' => 'bg-sky-50 border-sky-200 text-sky-800 dark:bg-sky-950/20 dark:border-sky-800/40 dark:text-sky-300',
                    'badge_color' => 'bg-sky-100 text-sky-800 dark:bg-sky-900/60 dark:text-sky-200',
                    'employees' => []
                ],
                'medium_potential' => [
                    'title' => 'نجم صاعد (مرشح لإدارة القسم)',
                    'description' => 'أداء ممتاز وإمكانات نمو واعدة. وفّر له مشاريع صعبة وتأهيل قيادي.',
                    'color_class' => 'bg-teal-50 border-teal-200 text-teal-800 dark:bg-teal-950/20 dark:border-teal-800/40 dark:text-teal-300',
                    'badge_color' => 'bg-teal-100 text-teal-800 dark:bg-teal-900/60 dark:text-teal-200',
                    'employees' => []
                ],
                'high_potential' => [
                    'title' => 'قائد مستقبلي موجه (الصف الأول)',
                    'description' => 'الذهب الخالص للمؤسسة. أداء متميز وإمكانات نمو قصوى. ضعه في خطط الإحلال والتمكين فوراً.',
                    'color_class' => 'bg-emerald-50 border-emerald-200 text-emerald-800 dark:bg-emerald-950/20 dark:border-emerald-800/40 dark:text-emerald-300',
                    'badge_color' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/60 dark:text-emerald-200',
                    'employees' => []
                ],
            ],
            'medium_performance' => [
                'low_potential' => [
                    'title' => 'موظف منجز للعمليات الأساسية فقط',
                    'description' => 'يلبي التوقعات ولكنه غير مهتم بالترقية. حافظ على أمنه الوظيفي وتدريبه التخصصي.',
                    'color_class' => 'bg-slate-50 border-slate-200 text-slate-800 dark:bg-slate-900/20 dark:border-slate-800/40 dark:text-slate-300',
                    'badge_color' => 'bg-slate-100 text-slate-800 dark:bg-slate-800/60 dark:text-slate-200',
                    'employees' => []
                ],
                'medium_potential' => [
                    'title' => 'موظف ذو أداء مستقر وقابل للتوجيه',
                    'description' => 'العمود الفقري للعمليات. أداء مستقر ونمو متوسط. عزز التوجيه المستمر وجلسات GROW.',
                    'color_class' => 'bg-blue-50 border-blue-200 text-blue-800 dark:bg-blue-950/20 dark:border-blue-800/40 dark:text-blue-300',
                    'badge_color' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/60 dark:text-blue-200',
                    'employees' => []
                ],
                'high_potential' => [
                    'title' => 'كادر واعد ذو إمكانيات غير مستغلة',
                    'description' => 'يلتزم بالحد الأدنى ولكن لديه طاقة كامنة ضخمة. ابحث عن الأسباب لتحفيزه ودعمه.',
                    'color_class' => 'bg-indigo-50 border-indigo-200 text-indigo-800 dark:bg-indigo-950/20 dark:border-indigo-800/40 dark:text-indigo-300',
                    'badge_color' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/60 dark:text-indigo-200',
                    'employees' => []
                ],
            ],
            'low_performance' => [
                'low_potential' => [
                    'title' => 'موظف متعثر (إخضاع لـ PIP)',
                    'description' => 'أداء منخفض وإمكانات نمو منخفضة. يجب إدخاله فوراً في خطة PIP صارمة (30-60-90 يوماً).',
                    'color_class' => 'bg-red-50 border-red-200 text-red-800 dark:bg-red-950/20 dark:border-red-800/40 dark:text-red-300',
                    'badge_color' => 'bg-red-100 text-red-800 dark:bg-red-900/60 dark:text-red-200',
                    'employees' => []
                ],
                'medium_potential' => [
                    'title' => 'موظف حديث العهد بحاجة لأمان ورعاية',
                    'description' => 'أداء منخفض بسبب الحداثة أو نقص المهارات ولكن يبدي شغف للنمو. وفر بيئة آمنة وتدريب مكثف.',
                    'color_class' => 'bg-orange-50 border-orange-200 text-orange-800 dark:bg-orange-950/20 dark:border-orange-800/40 dark:text-orange-300',
                    'badge_color' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/60 dark:text-orange-200',
                    'employees' => []
                ],
                'high_potential' => [
                    'title' => 'موظف في المكان غير المناسب (إعادة توجيه)',
                    'description' => 'أداء منخفض ولكن طاقة نمو عالية جداً. المشكلة تكمن في الدور أو القسم، أعد توجيهه.',
                    'color_class' => 'bg-amber-50 border-amber-200 text-amber-800 dark:bg-amber-950/20 dark:border-amber-800/40 dark:text-amber-300',
                    'badge_color' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/60 dark:text-amber-200',
                    'employees' => []
                ],
            ]
        ];

        $users = User::with(['goalsAndKpis', 'idps'])->where('role', 'employee')->get();

        foreach ($users as $user) {
            // Calculate Performance (Y-Axis)
            $avgKpi = $user->goalsAndKpis->avg('current_progress_rate') ?? 0.00;
            if ($avgKpi >= 115.00) {
                $perfKey = 'high_performance';
            } elseif ($avgKpi >= 80.00) {
                $perfKey = 'medium_performance';
            } else {
                $perfKey = 'low_performance';
            }

            // Calculate Potential (X-Axis)
            $latestIdp = $user->idps->sortByDesc('created_at')->first();
            if (!$latestIdp) {
                $potKey = 'low_potential';
            } else {
                if ($latestIdp->status === 'completed') {
                    $potKey = 'high_potential';
                } elseif ($latestIdp->status === 'active') {
                    $potKey = 'medium_potential';
                } else {
                    $potKey = 'low_potential';
                }
            }

            $boxes[$perfKey][$potKey]['employees'][] = [
                'id' => $user->id,
                'name' => $user->name,
                'avg_kpi' => round($avgKpi, 1),
                'idp_status' => $latestIdp ? $latestIdp->status : 'none',
                'idp_goal' => $latestIdp ? $latestIdp->career_goal : null,
            ];
        }

        $this->grid = $boxes;
    }
}
