<?php

namespace App\Filament\Resources\CriticalIncidentLogs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Schema;

class CriticalIncidentLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required()
                    ->label('الموظف المرصود له الواقعة'),

                Select::make('reporter_id')
                    ->relationship('reporter', 'name')
                    ->default(fn () => auth()->id())
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->label('الكوتش / الراصد'),

                DatePicker::make('incident_date')
                    ->required()
                    ->default(now())
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->label('تاريخ الواقعة'),

                Select::make('type')
                    ->options([
                        'positive' => 'إيجابي (Positive) - تميز وفعالية',
                        'negative' => 'سلبي (Negative) - تعثر أو سلوك غير فعال',
                    ])
                    ->required()
                    ->label('نوع الواقعة السلوكية'),

                TextArea::make('observed_situation')
                    ->required()
                    ->rows(3)
                    ->placeholder('صف الموقف وسياق الزمان والمكان بدقة دون أحكام مسبقة (Situation)...')
                    ->helperText('الموقف: أين ومتى حدث ذلك؟')
                    ->label('1. الموقف المشاهد (S)'),

                TextArea::make('actual_behavior')
                    ->required()
                    ->rows(3)
                    ->placeholder('صف السلوك الفعلي الملاحظ للموظف بالأفعال دون إطلاق ألقاب (Behavior)...')
                    ->helperText('السلوك: ما الذي فعله أو قاله الموظف بالضبط؟')
                    ->label('2. السلوك الفعلي المرصود (B)'),

                TextArea::make('result_impact')
                    ->required()
                    ->rows(3)
                    ->placeholder('اشرح الأثر المباشر الذي تركه هذا السلوك على الأداء، الزملاء، أو العملاء (Impact)...')
                    ->helperText('الأثر: ما هي نتيجة هذا السلوك على العمل؟')
                    ->label('3. الأثر الناتج (I)'),
            ]);
    }
}
