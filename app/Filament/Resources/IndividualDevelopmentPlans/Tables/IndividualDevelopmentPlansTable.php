<?php

namespace App\Filament\Resources\IndividualDevelopmentPlans\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class IndividualDevelopmentPlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('الموظف الواعد'),

                TextColumn::make('career_goal')
                    ->limit(40)
                    ->label('الهدف التمكيني'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'active' => 'primary',
                        'completed' => 'success',
                        'suspended' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'مسودة قيد الدراسة',
                        'active' => 'خطة نشطة وقيد التطبيق',
                        'completed' => 'مكتملة بنجاح (جاهز للترقية)',
                        'suspended' => 'معلقة مؤقتاً',
                        default => $state,
                    })
                    ->label('حالة الملف'),

                TextColumn::make('end_date')
                    ->date()
                    ->sortable()
                    ->label('تاريخ المراجعة والتطوير'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'مسودة قيد الدراسة',
                        'active' => 'نشط وقيد التطبيق',
                        'completed' => 'مكتمل بنجاح',
                        'suspended' => 'معلق مؤقتاً',
                    ])
                    ->label('تصفية بحالة الملف'),
            ])
            ->actions([
                \Filament\Actions\ViewAction::make(),
                \Filament\Actions\EditAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
