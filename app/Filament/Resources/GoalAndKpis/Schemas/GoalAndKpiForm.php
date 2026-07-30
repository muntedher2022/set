<?php

namespace App\Filament\Resources\GoalAndKpis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextArea;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

class GoalAndKpiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required()
                    ->label('الموظف المعني'),

                Select::make('perspective')
                    ->options([
                        'learning_growth' => 'التعلم والنمو (Learning & Growth)',
                        'internal_processes' => 'العمليات الداخلية (Internal Processes)',
                        'customer' => 'العملاء والشركاء (Customer/Stakeholder)',
                        'financial_strategic' => 'المالي والاستراتيجي (Financial/Strategic)',
                    ])
                    ->required()
                    ->label('منظور بطاقة الأداء المتوازن (BSC)'),

                TextArea::make('smart_goal_text')
                    ->required()
                    ->minLength(15)
                    ->placeholder('مثال: أتمتة نظام تقييم الأداء بالكامل لتقليل زمن معالجة الطلبات بنسبة 30% خلال 3 أشهر')
                    ->label('صياغة الهدف الذكي (SMART)'),

                TextInput::make('weight')
                    ->numeric()
                    ->required()
                    ->minValue(10.00)
                    ->maxValue(30.00)
                    ->rules([
                        function ($get, $record) {
                            return function (string $attribute, $value, $fail) use ($get, $record) {
                                $userId = $get('user_id');
                                if (!$userId) return;

                                $newWeight = floatval($value);
                                $currentTotalWeight = DB::table('goals_and_kpis')
                                    ->where('user_id', $userId)
                                    ->when($record, function ($query) use ($record) {
                                        return $query->where('id', '!=', $record->id);
                                    })
                                    ->sum('weight');

                                if ($currentTotalWeight + $newWeight > 100.00) {
                                    $fail("مجموع الأوزان الحالية للموظف هو {$currentTotalWeight}%. إضافة هذا الهدف بوزن {$newWeight}% يتجاوز الحد الأقصى الرياضي المسموح به (100%)!");
                                }
                            };
                        }
                    ])
                    ->helperText('الوزن النسبي يجب أن يكون بين 10% و 30%، والمجموع الإجمالي لأهداف الموظف يجب ألا يتجاوز 100%')
                    ->label('الوزن النسبي (%)'),

                TextInput::make('baseline')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->default(0)
                    ->label('خط الأساس (Baseline)'),

                TextInput::make('target')
                    ->numeric()
                    ->required()
                    ->rules([
                        function ($get) {
                            return function (string $attribute, $value, $fail) use ($get) {
                                $baseline = floatval($get('baseline'));
                                if (floatval($value) === $baseline) {
                                    $fail('يجب أن يكون المستهدف مختلفاً عن خط الأساس ليمثل هدفاً متمدداً (سواء بالزيادة أو النقصان لمؤشرات التقليل كالأخطاء).');
                                }
                            };
                        }
                    ])
                    ->label('المستهدف السنوي المتمدد (Target)'),

                TextInput::make('current_progress_rate')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->default(0)
                    ->helperText('القيمة الحالية المحققة من المستهدف (مثال: 50% أو قيمة رقمية متراكمة)')
                    ->label('الإنجاز الفعلي الحالي (%)'),

                Select::make('kpi_type')
                    ->options([
                        'leading' => 'مؤشر قيادي استباقي (Leading KPI)',
                        'lagging' => 'مؤشر متأخر استرجاعي (Lagging KPI)',
                    ])
                    ->required()
                    ->label('نوع مؤشر الأداء'),
            ]);
    }
}
