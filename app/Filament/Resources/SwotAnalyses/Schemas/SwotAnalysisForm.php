<?php

namespace App\Filament\Resources\SwotAnalyses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextArea;
use Filament\Schemas\Schema;

class SwotAnalysisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('scope')
                    ->options([
                        'institutional' => 'مؤسسي (على مستوى المؤسسة ككل)',
                        'departmental' => 'قسمي (على مستوى القسم أو الإدارة)',
                        'individual' => 'فردي (مرتبط بموظف محدد)',
                    ])
                    ->required()
                    ->reactive()
                    ->label('نطاق التحليل'),

                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->nullable()
                    ->visible(fn ($get) => $get('scope') === 'individual')
                    ->required(fn ($get) => $get('scope') === 'individual')
                    ->label('الموظف المعني (مطلوب في حال النطاق الفردي)'),

                Select::make('type')
                    ->options([
                        'strength' => 'قوة (Strength) - بيئة داخلية',
                        'weakness' => 'ضعف (Weakness) - بيئة داخلية',
                        'opportunity' => 'فرصة (Opportunity) - بيئة خارجية',
                        'threat' => 'تهديد (Threat) - بيئة خارجية',
                    ])
                    ->required()
                    ->label('نوع العنصر'),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('مثال: امتلاك كوادر فنية مدربة على أحدث التقنيات')
                    ->label('العنوان الرئيسي'),

                TextArea::make('description')
                    ->required()
                    ->rows(4)
                    ->placeholder('اكتب تفاصيل أكثر حول هذا العنصر وتأثيره الإستراتيجي...')
                    ->label('الوصف والتحليل التفصيلي'),
            ]);
    }
}
