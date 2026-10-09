<?php

namespace App\Filament\Resources\SwotAnalyses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SwotAnalysesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('scope')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'institutional' => 'primary',
                        'departmental' => 'warning',
                        'individual' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'institutional' => 'مؤسسي',
                        'departmental' => 'قسمي',
                        'individual' => 'فردي',
                        default => $state,
                    })
                    ->label('النطاق'),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'strength' => 'success',
                        'weakness' => 'danger',
                        'opportunity' => 'info',
                        'threat' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'strength' => 'قوة (S)',
                        'weakness' => 'ضعف (W)',
                        'opportunity' => 'فرصة (O)',
                        'threat' => 'تهديد (T)',
                        default => $state,
                    })
                    ->label('النوع'),

                TextColumn::make('title')
                    ->searchable()
                    ->limit(50)
                    ->label('العنوان'),

                TextColumn::make('user.name')
                    ->placeholder('تحليل عام غير مرتبط بفرد')
                    ->label('الموظف المعني'),

                TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->label('تاريخ الإضافة'),
            ])
            ->filters([
                SelectFilter::make('scope')
                    ->options([
                        'institutional' => 'مؤسسي',
                        'departmental' => 'قسمي',
                        'individual' => 'فردي',
                    ])
                    ->label('تصفية بالنطاق'),

                SelectFilter::make('type')
                    ->options([
                        'strength' => 'نقاط القوة',
                        'weakness' => 'نقاط الضعف',
                        'opportunity' => 'الفرص المتاحة',
                        'threat' => 'التهديدات الخارجية',
                    ])
                    ->label('تصفية بنوع العنصر'),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
