<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('الاسم الكامل'),
                
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->label('البريد الإلكتروني'),
                
                TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->label('كلمة المرور'),
                
                Select::make('role')
                    ->options([
                        'admin' => 'مدير النظام (Admin)',
                        'coach' => 'موجه / كوتش (Coach)',
                        'employee' => 'موظف (Employee)',
                    ])
                    ->required()
                    ->default('employee')
                    ->label('الدور الصلاحياتي'),

                Select::make('manager_id')
                    ->relationship('manager', 'name', fn ($query) => $query->whereIn('role', ['admin', 'coach']))
                    ->searchable()
                    ->nullable()
                    ->label('المشرف / الكوتش المباشر'),
            ]);
    }
}
