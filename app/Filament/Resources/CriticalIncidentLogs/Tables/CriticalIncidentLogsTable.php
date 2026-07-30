<?php

namespace App\Filament\Resources\CriticalIncidentLogs\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class CriticalIncidentLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('الموظف'),

                TextColumn::make('reporter.name')
                    ->placeholder('غير محدد')
                    ->label('الكوتش الراصد'),

                TextColumn::make('incident_date')
                    ->date()
                    ->sortable()
                    ->label('تاريخ الواقعة'),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'positive' => 'success',
                        'negative' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'positive' => 'إيجابي (سلوك فعال)',
                        'negative' => 'سلبي (سلوك غير فعال)',
                        default => $state,
                    })
                    ->label('نوع السلوك'),

                TextColumn::make('observed_situation')
                    ->limit(30)
                    ->label('الموقف (S)'),

                TextColumn::make('actual_behavior')
                    ->limit(30)
                    ->label('السلوك (B)'),

                TextColumn::make('result_impact')
                    ->limit(30)
                    ->label('الأثر (I)'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'positive' => 'الوقائع الإيجابية',
                        'negative' => 'الوقائع السلبية',
                    ])
                    ->label('تصفية بنوع السلوك'),
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
