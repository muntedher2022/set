<?php

namespace App\Filament\Resources\CriticalIncidentLogs;

use App\Filament\Resources\CriticalIncidentLogs\Pages\CreateCriticalIncidentLog;
use App\Filament\Resources\CriticalIncidentLogs\Pages\EditCriticalIncidentLog;
use App\Filament\Resources\CriticalIncidentLogs\Pages\ListCriticalIncidentLogs;
use App\Filament\Resources\CriticalIncidentLogs\Schemas\CriticalIncidentLogForm;
use App\Filament\Resources\CriticalIncidentLogs\Tables\CriticalIncidentLogsTable;
use App\Models\CriticalIncidentLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CriticalIncidentLogResource extends Resource
{
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $query;
        }

        if ($user->isCoach()) {
            return $query->whereHas('user', function ($q) use ($user) {
                $q->where('manager_id', $user->id);
            });
        }

        return $query->where('user_id', $user->id);
    }
    protected static ?string $model = CriticalIncidentLog::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-fire';

    protected static ?string $navigationLabel = 'سجل الوقائع الحرجة (SBI)';

    protected static ?string $pluralModelLabel = 'سجلات الوقائع الحرجة';

    protected static ?string $modelLabel = 'واقعة حرجة';

    public static function form(Schema $schema): Schema
    {
        return CriticalIncidentLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CriticalIncidentLogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCriticalIncidentLogs::route('/'),
            'create' => CreateCriticalIncidentLog::route('/create'),
            'edit' => EditCriticalIncidentLog::route('/{record}/edit'),
        ];
    }
}
