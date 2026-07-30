<?php

namespace App\Filament\Resources\SwotAnalyses;

use App\Filament\Resources\SwotAnalyses\Pages\CreateSwotAnalysis;
use App\Filament\Resources\SwotAnalyses\Pages\EditSwotAnalysis;
use App\Filament\Resources\SwotAnalyses\Pages\ListSwotAnalyses;
use App\Filament\Resources\SwotAnalyses\Schemas\SwotAnalysisForm;
use App\Filament\Resources\SwotAnalyses\Tables\SwotAnalysesTable;
use App\Models\SwotAnalysis;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SwotAnalysisResource extends Resource
{
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $query;
        }

        if ($user->isCoach()) {
            return $query->where(function ($q) use ($user) {
                $q->where('scope', 'institutional')
                  ->orWhereHas('user', function ($qu) use ($user) {
                      $qu->where('manager_id', $user->id);
                  });
            });
        }

        return $query->where('user_id', $user->id);
    }
    protected static ?string $model = SwotAnalysis::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'تحليل SWOT الإستراتيجي';

    protected static ?string $pluralModelLabel = 'تحليلات SWOT الإستراتيجية';

    protected static ?string $modelLabel = 'تحليل SWOT';

    public static function form(Schema $schema): Schema
    {
        return SwotAnalysisForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SwotAnalysesTable::configure($table);
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
            'index' => ListSwotAnalyses::route('/'),
            'create' => CreateSwotAnalysis::route('/create'),
            'edit' => EditSwotAnalysis::route('/{record}/edit'),
        ];
    }
}
