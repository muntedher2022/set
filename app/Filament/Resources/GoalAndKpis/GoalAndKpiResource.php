<?php

namespace App\Filament\Resources\GoalAndKpis;

use App\Filament\Resources\GoalAndKpis\Pages\CreateGoalAndKpi;
use App\Filament\Resources\GoalAndKpis\Pages\EditGoalAndKpi;
use App\Filament\Resources\GoalAndKpis\Pages\ListGoalAndKpis;
use App\Filament\Resources\GoalAndKpis\Schemas\GoalAndKpiForm;
use App\Filament\Resources\GoalAndKpis\Tables\GoalAndKpisTable;
use App\Models\GoalAndKpi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GoalAndKpiResource extends Resource
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
    protected static ?string $model = GoalAndKpi::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?string $navigationLabel = 'بطاقة الأداء والأهداف (BSC)';

    protected static ?string $pluralModelLabel = 'بطاقات الأداء والأهداف (KPIs)';

    protected static ?string $modelLabel = 'هدف ومؤشر';

    public static function form(Schema $schema): Schema
    {
        return GoalAndKpiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GoalAndKpisTable::configure($table);
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
            'index' => ListGoalAndKpis::route('/'),
            'create' => CreateGoalAndKpi::route('/create'),
            'edit' => EditGoalAndKpi::route('/{record}/edit'),
        ];
    }
}
