<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('الاسم'),
                
                TextColumn::make('email')
                    ->searchable()
                    ->label('البريد الإلكتروني'),
                
                TextColumn::make('phone')
                    ->searchable()
                    ->default('—')
                    ->label('رقم الهاتف'),
                
                TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'coach' => 'warning',
                        'employee' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'مدير النظام',
                        'coach' => 'كوتش / موجه',
                        'employee' => 'موظف',
                        default => $state,
                    })
                    ->label('الدور'),
                
                TextColumn::make('manager.name')
                    ->placeholder('لا يوجد مشرف مباشر')
                    ->label('المشرف المباشر'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('تاريخ الإنشاء'),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'مدير النظام',
                        'coach' => 'كوتش / موجه',
                        'employee' => 'موظف',
                    ])
                    ->label('تصفية حسب الدور'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
