<?php

namespace App\Filament\Resources\PerformanceImprovementPlans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PerformanceImprovementPlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('الموظف المتعثر'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'danger',
                        'successful' => 'success',
                        'unsuccessful' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'نشط وقيد التطبيق',
                        'successful' => 'ناجح (تم ردم الفجوة)',
                        'unsuccessful' => 'فاشل (لم يتحسن الأداء)',
                        default => $state,
                    })
                    ->label('حالة البرنامج'),

                TextColumn::make('start_date')
                    ->date()
                    ->label('تاريخ البدء'),

                TextColumn::make('end_date')
                    ->date()
                    ->sortable()
                    ->label('تاريخ المراجعة والتقييم'),

                IconColumn::make('employee_signed')
                    ->boolean()
                    ->label('توقيع الموظف'),

                IconColumn::make('manager_signed')
                    ->boolean()
                    ->label('توقيع المدير'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'نشط وقيد التطبيق',
                        'successful' => 'ناجح (تم ردم الفجوة)',
                        'unsuccessful' => 'غير ناجح',
                    ])
                    ->label('تصفية بحالة الملف'),
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
