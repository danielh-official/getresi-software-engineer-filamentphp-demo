<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Filament\Resources\Properties\PropertyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class PropertiesRelationManager extends RelationManager
{
    protected static string $relationship = 'properties';

    protected static ?string $relatedResource = PropertyResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ])
            ->inverseRelationship('owner');
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
