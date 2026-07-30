<?php

namespace App\Filament\Resources\GoalAndKpis\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class GoalAndKpisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('الموظف'),

                TextColumn::make('perspective')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'learning_growth' => 'info',
                        'internal_processes' => 'primary',
                        'customer' => 'success',
                        'financial_strategic' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'learning_growth' => 'التعلم والنمو',
                        'internal_processes' => 'العمليات الداخلية',
                        'customer' => 'العملاء والشركاء',
                        'financial_strategic' => 'المالي والاستراتيجي',
                        default => $state,
                    })
                    ->label('منظور BSC'),

                TextColumn::make('smart_goal_text')
                    ->searchable()
                    ->limit(40)
                    ->label('الهدف (SMART)'),

                TextColumn::make('weight')
                    ->formatStateUsing(fn ($state) => "{$state}%")
                    ->sortable()
                    ->label('الوزن'),

                TextColumn::make('baseline')
                    ->numeric()
                    ->label('خط الأساس'),

                TextColumn::make('target')
                    ->numeric()
                    ->label('المستهدف'),

                TextColumn::make('current_progress_rate')
                    ->formatStateUsing(fn ($state) => "{$state}%")
                    ->sortable()
                    ->label('الإنجاز الفعلي'),

                TextColumn::make('kpi_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'leading' => 'success',
                        'lagging' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'leading' => 'قيادي (Leading)',
                        'lagging' => 'متأخر (Lagging)',
                        default => $state,
                    })
                    ->label('نوع المؤشر'),
            ])
            ->filters([
                SelectFilter::make('perspective')
                    ->options([
                        'learning_growth' => 'التعلم والنمو',
                        'internal_processes' => 'العمليات الداخلية',
                        'customer' => 'العملاء والشركاء',
                        'financial_strategic' => 'المالي والاستراتيجي',
                    ])
                    ->label('تصفية بالمنظور'),

                SelectFilter::make('kpi_type')
                    ->options([
                        'leading' => 'قيادي استباقي',
                        'lagging' => 'متأخر استرجاعي',
                    ])
                    ->label('تصفية بنوع المؤشر'),
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
