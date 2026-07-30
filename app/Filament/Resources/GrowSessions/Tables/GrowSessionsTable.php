<?php

namespace App\Filament\Resources\GrowSessions\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GrowSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('الموظف المعني'),

                TextColumn::make('coach.name')
                    ->placeholder('غير محدد')
                    ->label('الموجه / الكوتش'),

                TextColumn::make('session_date')
                    ->date()
                    ->sortable()
                    ->label('تاريخ الجلسة'),

                TextColumn::make('goal')
                    ->limit(40)
                    ->label('الهدف المراد تحقيقه (G)'),

                TextColumn::make('way_forward')
                    ->limit(40)
                    ->label('خطة العمل والمتابعة (W)'),
            ])
            ->filters([
                //
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
