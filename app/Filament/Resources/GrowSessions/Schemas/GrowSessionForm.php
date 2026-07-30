<?php

namespace App\Filament\Resources\GrowSessions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;

class GrowSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required()
                    ->label('الموظف المعني بالجلسة'),

                Select::make('coach_id')
                    ->relationship('coach', 'name')
                    ->default(fn () => auth()->id())
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->label('الكوتش / الموجه المتابع'),

                DatePicker::make('session_date')
                    ->required()
                    ->default(now())
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->label('تاريخ انعقاد الجلسة'),

                TextArea::make('goal')
                    ->required()
                    ->rows(3)
                    ->placeholder('مثال: زيادة سرعة كتابة التقارير البرمجية بنسبة 20%...')
                    ->helperText('الهدف (Goal): ما الذي يريد الموظف تحسينه وإنجازه اليوم؟')
                    ->label('1. الهدف المراد تحقيقه (G)'),

                TextArea::make('reality')
                    ->required()
                    ->rows(3)
                    ->placeholder('مثال: الوقت الحالي المستغرق لكتابة التقرير هو 5 ساعات بمتوسط خطأ 5%...')
                    ->helperText('الواقع الحالي (Reality): تشخيص دقيق وعميق للوضع الحالي بالأرقام والوقائع.')
                    ->label('2. تشخيص الواقع الحالي الفعلي (R)'),

                TextArea::make('options')
                    ->required()
                    ->rows(3)
                    ->placeholder('مثال: استخدام نماذج جاهزة، التدريب على تقنيات Filament المتقدمة...')
                    ->helperText('الخيارات (Options): الحلول والخيارات المتاحة والبدائل المطروحة من وجهة نظر الموظف نفسه.')
                    ->label('3. الخيارات والحلول من الموظف (O)'),

                TextArea::make('way_forward')
                    ->required()
                    ->rows(3)
                    ->placeholder('مثال: الالتزام بإنهاء نموذج التقارير الجاهز بحلول الأسبوع القادم، والمراجعة في 25/7/2026...')
                    ->helperText('طريقة التقدم (Way Forward): خطة العمل المحددة، التوقيت، وجدول المراجعة القادم.')
                    ->label('4. خطة العمل وتحديد المسؤوليات (W)'),
            ]);
    }
}
