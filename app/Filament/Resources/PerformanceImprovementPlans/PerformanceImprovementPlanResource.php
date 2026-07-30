<?php

namespace App\Filament\Resources\PerformanceImprovementPlans;

use App\Filament\Resources\PerformanceImprovementPlans\Pages\CreatePerformanceImprovementPlan;
use App\Filament\Resources\PerformanceImprovementPlans\Pages\EditPerformanceImprovementPlan;
use App\Filament\Resources\PerformanceImprovementPlans\Pages\ListPerformanceImprovementPlans;
use App\Filament\Resources\PerformanceImprovementPlans\Schemas\PerformanceImprovementPlanForm;
use App\Filament\Resources\PerformanceImprovementPlans\Tables\PerformanceImprovementPlansTable;
use App\Models\PerformanceImprovementPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PerformanceImprovementPlanResource extends Resource
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
    protected static ?string $model = PerformanceImprovementPlan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationLabel = 'خطط تحسين الأداء (PIP)';

    protected static ?string $pluralModelLabel = 'برامج تحسين الأداء (PIPs)';

    protected static ?string $modelLabel = 'خطة تحسين أداء';

    public static function form(Schema $schema): Schema
    {
        return PerformanceImprovementPlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PerformanceImprovementPlansTable::configure($table);
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
            'index' => ListPerformanceImprovementPlans::route('/'),
            'create' => CreatePerformanceImprovementPlan::route('/create'),
            'edit' => EditPerformanceImprovementPlan::route('/{record}/edit'),
        ];
    }
}
