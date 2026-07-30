<?php

namespace App\Filament\Resources\PerformanceImprovementPlans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PerformanceImprovementPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('معلومات الموظف وفترة الخطة')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required()
                            ->label('الموظف المعني بالخطة (المتعثر)'),

                        DatePicker::make('start_date')
                            ->required()
                            ->default(now())
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->label('تاريخ بدء الخطة'),

                        DatePicker::make('end_date')
                            ->required()
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->label('تاريخ انتهاء الخطة والتقييم (30-60-90 يوماً)'),
                    ]),

                Section::make('الحالة الحالية')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'active' => 'خطة نشطة وقيد التنفيذ والتقييم',
                                'successful' => 'اكتملت بنجاح (تم ردم الفجوة بنجاح)',
                                'unsuccessful' => 'غير ناجحة (لم يتم الوفاء بالمستهدفات)',
                            ])
                            ->required()
                            ->default('active')
                            ->label('حالة البرنامج التصحيحي'),
                    ]),

                Section::make('الهيكل التفصيلي لوثيقة الـ PIP الرسمية')
                    ->schema([
                        TextArea::make('gap_description')
                            ->required()
                            ->rows(4)
                            ->placeholder('اكتب هنا فجوة الأداء مستنداً بشكل صارم للأرقام والوقائع الحرجة السلبية المرصودة...')
                            ->helperText('مثال: تراجع نسبة الإنجاز في KPI خدمة العملاء لـ 60% مع تسجيل 3 وقائع سلبية في التعامل مع الشكاوى.')
                            ->label('1. وصف الفجوة التشغيلية أو السلوكية'),

                        TextArea::make('strict_targets')
                            ->required()
                            ->rows(4)
                            ->placeholder('اكتب هنا المستهدفات الصارمة والمحددة الواجب تحقيقها بتواريخ محددة خلال المهلة الممنوحة...')
                            ->helperText('مثال: تسليم كافة المهام البرمجية دون أخطاء لمدة 30 يوماً متتالية، وتحقيق 85% في تقييم الرضا.')
                            ->label('2. المستهدفات والمهام الصارمة المطلوبة للتحسن'),

                        TextArea::make('management_support')
                            ->required()
                            ->rows(4)
                            ->placeholder('اكتب هنا الدعم والتدريب والمتابعة اليومية التي ستوفرها الإدارة لمساعدة الموظف...')
                            ->helperText('مثال: جلسة توجيه GROW يومية لمدة 15 دقيقة، وإسناد موجه فني للمتابعة اللحظية.')
                            ->label('3. التزامات الإدارة والدعم والتمكين المقدم للموظف'),
                    ]),

                Section::make('التعهد والتوقيعات القانونية والإدارية')
                    ->schema([
                        Toggle::make('employee_signed')
                            ->inline(false)
                            ->helperText('إقرار الموظف بفهم وتلقي الوثيقة والالتزام بالمستهدفات')
                            ->label('توقيع وإقرار الموظف المعني بالخطة'),

                        Toggle::make('manager_signed')
                            ->inline(false)
                            ->helperText('إقرار المدير الإداري بالالتزام التام بتوفير الدعم المطلوب')
                            ->label('توقيع وإقرار المدير المباشر / الكوتش'),
                    ])
                    ->columns(2),
            ]);
    }
}
