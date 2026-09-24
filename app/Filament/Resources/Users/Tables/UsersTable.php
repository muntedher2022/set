<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
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

                TextColumn::make('totp_status')
                    ->label('المصادقة بالتطبيق (TOTP)')
                    ->badge()
                    ->state(function (User $record): string {
                        if (!$record->isTotpRequired()) {
                            return 'غير ملزم';
                        }
                        return $record->hasTotpSetup() ? 'مفعّل ومرتبط' : 'ملزم - بانتظار الإعداد';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'مفعّل ومرتبط' => 'success',
                        'ملزم - بانتظار الإعداد' => 'warning',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): ?string => match ($state) {
                        'مفعّل ومرتبط' => 'heroicon-o-check-circle',
                        'ملزم - بانتظار الإعداد' => 'heroicon-o-clock',
                        default => 'heroicon-o-minus-circle',
                    }),
                
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
                Action::make('reset_totp')
                    ->label('إلغاء ربط التطبيق')
                    ->icon('heroicon-o-arrow-path')
                    ->color('danger')
                    ->visible(fn (User $record): bool => $record->hasTotpSetup())
                    ->requiresConfirmation()
                    ->modalHeading('إعادة ضبط تطبيق المصادقة')
                    ->modalDescription('هل أنت متأكد من رغبتك في إلغاء ربط تطبيق المصادقة لهذا المستخدم؟ سيُطلب منه مسح رمز QR جديد عند تسجيل دخوله القادم.')
                    ->modalSubmitActionLabel('نعم، إلغاء الربط')
                    ->action(function (User $record): void {
                        $record->resetTotp();
                        Notification::make()
                            ->title('تمت إعادة ضبط TOTP')
                            ->body('تم إلغاء ربط تطبيق المصادقة للمستخدم ' . $record->name . ' بنجاح.')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
