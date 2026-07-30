<?php

namespace App\Filament\Resources\IndividualDevelopmentPlans;

use App\Filament\Resources\IndividualDevelopmentPlans\Pages\CreateIndividualDevelopmentPlan;
use App\Filament\Resources\IndividualDevelopmentPlans\Pages\EditIndividualDevelopmentPlan;
use App\Filament\Resources\IndividualDevelopmentPlans\Pages\ListIndividualDevelopmentPlans;
use App\Filament\Resources\IndividualDevelopmentPlans\Schemas\IndividualDevelopmentPlanForm;
use App\Filament\Resources\IndividualDevelopmentPlans\Tables\IndividualDevelopmentPlansTable;
use App\Models\IndividualDevelopmentPlan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class IndividualDevelopmentPlanResource extends Resource
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
    protected static ?string $model = IndividualDevelopmentPlan::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'خطط التطوير الفردية (IDP)';

    protected static ?string $pluralModelLabel = 'برامج التطوير الفردي (IDPs)';

    protected static ?string $modelLabel = 'خطة تطوير فردية';

    public static function form(Schema $schema): Schema
    {
        return IndividualDevelopmentPlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IndividualDevelopmentPlansTable::configure($table);
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
            'index' => ListIndividualDevelopmentPlans::route('/'),
            'create' => CreateIndividualDevelopmentPlan::route('/create'),
            'edit' => EditIndividualDevelopmentPlan::route('/{record}/edit'),
        ];
    }
}
