<?php

namespace App\Filament\Resources\Properties\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PropertyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required(),
                Section::make('Property Details')
                    ->columns(2)
                    ->components([
                        Select::make('owner_id')
                            ->relationship('owner', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('type')
                            ->options([
                                'house' => 'House',
                                'apartment' => 'Apartment',
                                'condo' => 'Condo',
                                'townhouse' => 'Townhouse',
                                'land' => 'Land',
                            ])
                            ->required(),
                        TextInput::make('status'),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        TextInput::make('year_built')
                            ->numeric(),
                        TextInput::make('website')
                            ->url(),
                        TextInput::make('price')
                            ->numeric()
                            ->prefix('$'),
                    ]),
                Section::make('Address')
                    ->columns(2)
                    ->components([
                        Textarea::make('full_address')
                            ->columnSpanFull(),
                        TextInput::make('address'),
                        TextInput::make('city'),
                        TextInput::make('state'),
                        TextInput::make('zip_code'),
                    ]),
                Section::make('Features')
                    ->collapsible()
                    ->persistCollapsed()
                    ->columns(2)
                    ->components([
                        TextInput::make('stories')
                            ->numeric(),
                        Toggle::make('has_basement'),
                        Toggle::make('basement_finished'),
                        TextInput::make('bedrooms')
                            ->numeric(),
                        TextInput::make('bathrooms')
                            ->numeric(),
                        TextInput::make('square_feet')
                            ->numeric(),
                        Toggle::make('parking'),
                        Toggle::make('pets_allowed'),
                        Textarea::make('other')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
