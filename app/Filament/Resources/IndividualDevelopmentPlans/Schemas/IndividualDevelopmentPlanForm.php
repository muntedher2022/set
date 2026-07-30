<?php

namespace App\Filament\Resources\IndividualDevelopmentPlans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;

class IndividualDevelopmentPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('معلومات المسار المهني والتمكين')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->label('الموظف المستهدف (الواعد)'),
                        
                        Select::make('mentor_id')
                            ->relationship('mentor', 'name', fn ($query) => $query->whereIn('role', ['admin', 'coach']))
                            ->searchable()
                            ->required()
                            ->label('الموجه الإداري (Mentor)'),

                        TextInput::make('career_goal')
                            ->required()
                            ->placeholder('مثال: تأهيل الموظف لتولي منصب رئيس قسم...')
                            ->label('الهدف المهني المستقبلي والتمكيني'),

                        Select::make('status')
                            ->options([
                                'draft' => 'مسودة قيد الدراسة والتعديل',
                                'active' => 'خطة نشطة وقيد التطبيق العملي',
                                'completed' => 'مكتملة بنجاح (جاهز للترقية)',
                                'suspended' => 'معلقة مؤقتاً لأسباب تشغيلية',
                            ])
                            ->required()
                            ->default('draft')
                            ->label('حالة البرنامج التطويري'),

                        DatePicker::make('start_date')
                            ->required()
                            ->default(now())
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->reactive()
                            ->afterStateUpdated(fn ($state, $set, $get) => self::updateDuration($set, $get))
                            ->label('تاريخ انطلاق الخطة'),

                        DatePicker::make('end_date')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->reactive()
                            ->afterStateUpdated(fn ($state, $set, $get) => self::updateDuration($set, $get))
                            ->label('تاريخ المراجعة والتقييم النهائي'),

                        TextInput::make('duration_in_months')
                            ->numeric()
                            ->disabled()
                            ->placeholder('تُحسب تلقائياً')
                            ->label('أشهر تنفيذ الخطة (المدة)'),
                    ])
                    ->columns(4),

                Section::make('المهارات والاهداف التفصيلية المستهدفة للنمو')
                    ->schema([
                        Repeater::make('objectives') // Relationship is objectives()
                            ->relationship('objectives')
                            ->schema([
                                Grid::make()->columns(3)
                                    ->schema([
                                        TextInput::make('development_area')
                                            ->required()
                                            ->placeholder('مثال: مهارة استخدام حزمة Filament وتصميم البيانات')
                                            ->label('مجال التطوير (فني / سلوكي)'),

                                        Select::make('learning_type')
                                            ->options([
                                                'experiential' => 'ممارسة وعمل ميداني (70%)',
                                                'exposure' => 'توجيه وتعلم اجتماعي (20%)',
                                                'formal' => 'تدريب وتعليم رسمي (10%)',
                                            ])
                                            ->required()
                                            ->default('experiential')
                                            ->label('نوع نشاط التعلم (قاعدة 70-20-10)'),

                                        Select::make('status')
                                            ->options([
                                                'not_started' => 'لم تبدأ بعد',
                                                'in_progress' => 'قيد العمل والتدريب',
                                                'completed' => 'تم اكتساب المهارة بنجاح',
                                            ])
                                            ->required()
                                            ->default('not_started')
                                            ->label('الحالة الحالية للمهارة'),
                                    ]),

                                Grid::make()->columns(4)
                                    ->schema([
                                        Select::make('scheduling_type')
                                            ->options([
                                                'range' => 'نطاق أشهر متتالية (مثال: من الشهر 3 إلى 8)',
                                                'specific' => 'أشهر محددة ومنفصلة (مثال: الأشهر 3 و 5 و 9)',
                                            ])
                                            ->required()
                                            ->default('range')
                                            ->reactive()
                                            ->label('طريقة الجدولة الزمنية'),

                                        Select::make('start_month')
                                            ->options(fn ($get) => self::getMonthOptions($get))
                                            ->visible(fn ($get) => $get('scheduling_type') === 'range')
                                            ->required(fn ($get) => $get('scheduling_type') === 'range')
                                            ->rules([
                                                fn ($get) => function (string $attribute, $value, \Closure $fail) use ($get) {
                                                    $options = self::getMonthOptions($get);
                                                    $validKeys = array_keys($options);
                                                    if (!in_array((int)$value, $validKeys)) {
                                                        $fail("الشهر المحدد لا يقع ضمن فترة الخطة.");
                                                    }
                                                }
                                            ])
                                            ->label('من الشهر الرقم'),

                                        Select::make('end_month')
                                            ->options(fn ($get) => self::getMonthOptions($get))
                                            ->visible(fn ($get) => $get('scheduling_type') === 'range')
                                            ->required(fn ($get) => $get('scheduling_type') === 'range')
                                            ->rules([
                                                fn ($get) => function (string $attribute, $value, \Closure $fail) use ($get) {
                                                    $options = self::getMonthOptions($get);
                                                    $validKeys = array_keys($options);
                                                    
                                                    if (!in_array((int)$value, $validKeys)) {
                                                        $fail("الشهر المحدد لا يقع ضمن فترة الخطة.");
                                                        return;
                                                    }
                                                    
                                                    $startVal = $get('start_month');
                                                    if ($startVal && (int)$value < (int)$startVal) {
                                                        $fail("شهر النهاية لا يمكن أن يكون قبل شهر البداية.");
                                                    }
                                                }
                                            ])
                                            ->label('إلى الشهر الرقم'),

                                        Select::make('specific_months')
                                            ->options(fn ($get) => self::getMonthOptions($get))
                                            ->multiple()
                                            ->visible(fn ($get) => $get('scheduling_type') === 'specific')
                                            ->required(fn ($get) => $get('scheduling_type') === 'specific')
                                            ->rules([
                                                fn ($get) => function (string $attribute, $value, \Closure $fail) use ($get) {
                                                    $options = self::getMonthOptions($get);
                                                    $validKeys = array_keys($options);
                                                    if (is_array($value)) {
                                                        foreach ($value as $val) {
                                                            if (!in_array((int)$val, $validKeys)) {
                                                                $fail("أشهر التطوير المحددة لا يمكن أن تتجاوز مدة الخطة.");
                                                                return;
                                                            }
                                                        }
                                                    }
                                                }
                                            ])
                                            ->columnSpan(2)
                                            ->label('تحديد الأشهر النشطة'),
                                    ]),

                                Grid::make()->columns(2)
                                    ->schema([
                                        TextArea::make('action_steps')
                                            ->required()
                                            ->placeholder('مثال: حضور ورشة تخصصية، العمل على مشروع محلي مصغر...')
                                            ->rows(3)
                                            ->label('الخطوات التنفيذية والميكروسكوبية للتطبيق'),

                                        TextArea::make('support_needed')
                                            ->required()
                                            ->placeholder('مثال: تغطية رسوم الدورة الفنية، توفير ساعتي عمل يومياً للتعلم...')
                                            ->rows(3)
                                            ->label('الدعم والتدريب المطلوب من المؤسسة'),
                                    ]),

                                TextInput::make('measure_of_success')
                                    ->required()
                                    ->placeholder('مثال: تسليم نموذج أولي متكامل للنظام دون أخطاء')
                                    ->columnSpanFull()
                                    ->label('معيار قياس التمكن والنجاح'),
                            ])
                            ->label('الأهداف التفصيلية للتطوير والتمكين'),
                    ]),

                Section::make('المخطط الزمني للأنشطة والتطوير (Gantt Chart)')
                    ->schema([
                        \Filament\Forms\Components\Placeholder::make('gantt_chart')
                            ->content(fn ($record) => $record ? view('filament.components.idp-gantt-chart', ['record' => $record]) : 'الرجاء حفظ الخطة أولاً لتوليد المخطط الزمني.')
                            ->label(''),
                    ]),
            ]);
    }

    public static function calculateDuration($get): int
    {
        $start = $get('start_date') 
            ?? $get('../start_date') 
            ?? $get('../../start_date') 
            ?? $get('../../../start_date') 
            ?? $get('../../../../start_date');
        $end = $get('end_date') 
            ?? $get('../end_date') 
            ?? $get('../../end_date') 
            ?? $get('../../../end_date') 
            ?? $get('../../../../end_date');

        if ($start && $end) {
            try {
                $startDate = \Carbon\Carbon::parse($start);
                $endDate = \Carbon\Carbon::parse($end);
                return max(1, $startDate->diffInMonths($endDate));
            } catch (\Exception $e) {
                return 12;
            }
        }

        return 12; // default
    }

    public static function getMonthOptions($get): array
    {
        $start = $get('start_date') 
            ?? $get('../start_date') 
            ?? $get('../../start_date') 
            ?? $get('../../../start_date') 
            ?? $get('../../../../start_date');
        
        $duration = self::calculateDuration($get);
        
        $startMonth = 1;
        if ($start) {
            try {
                $startMonth = \Carbon\Carbon::parse($start)->month;
            } catch (\Exception $e) {
                $startMonth = 1;
            }
        }
        
        $options = [];
        $arabicMonths = [
            1 => 'يناير',
            2 => 'فبراير',
            3 => 'مارس',
            4 => 'أبريل',
            5 => 'مايو',
            6 => 'يونيو',
            7 => 'يوليو',
            8 => 'أغسطس',
            9 => 'سبتمبر',
            10 => 'أكتوبر',
            11 => 'نوفمبر',
            12 => 'ديسمبر',
        ];
        
        for ($i = 1; $i <= $duration; $i++) {
            $val = $startMonth + $i - 1;
            $monthNum = (($val - 1) % 12) + 1;
            $yearSuffix = ($val > 12) ? " - السنة الثانية" : "";
            $options[$val] = "الشهر $monthNum (" . $arabicMonths[$monthNum] . ")$yearSuffix";
        }
        
        return $options;
    }

    public static function updateDuration($set, $get)
    {
        $start = $get('start_date');
        $end = $get('end_date');
        if ($start && $end) {
            try {
                $startDate = \Carbon\Carbon::parse($start);
                $endDate = \Carbon\Carbon::parse($end);
                $duration = max(1, $startDate->diffInMonths($endDate));
                $set('duration_in_months', $duration);
            } catch (\Exception $e) {
                // do nothing
            }
        }
    }
}
