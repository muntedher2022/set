<?php

namespace App\Filament\Resources\GrowSessions;

use App\Filament\Resources\GrowSessions\Pages\CreateGrowSession;
use App\Filament\Resources\GrowSessions\Pages\EditGrowSession;
use App\Filament\Resources\GrowSessions\Pages\ListGrowSessions;
use App\Filament\Resources\GrowSessions\Schemas\GrowSessionForm;
use App\Filament\Resources\GrowSessions\Tables\GrowSessionsTable;
use App\Models\GrowSession;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GrowSessionResource extends Resource
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
    protected static ?string $model = GrowSession::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'جلسات التوجيه (GROW)';

    protected static ?string $pluralModelLabel = 'جلسات الكوتشينج والتوجيه (GROW)';

    protected static ?string $modelLabel = 'جلسة توجيه';

    public static function form(Schema $schema): Schema
    {
        return GrowSessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GrowSessionsTable::configure($table);
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
            'index' => ListGrowSessions::route('/'),
            'create' => CreateGrowSession::route('/create'),
            'edit' => EditGrowSession::route('/{record}/edit'),
        ];
    }
}
