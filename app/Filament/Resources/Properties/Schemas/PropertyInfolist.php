<?php

namespace App\Filament\Resources\Properties\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PropertyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make('Tabs')
                    ->persistTab()
                    ->tabs([
                        Tab::make('Property Details')
                            ->schema([
                                Section::make('Basic Information')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('name'),
                                        TextEntry::make('type_display'),
                                        TextEntry::make('status'),
                                        TextEntry::make('year_built')
                                            ->numeric(),
                                        TextEntry::make('website'),
                                        TextEntry::make('price')
                                            ->money(),
                                        TextEntry::make('description')
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Address')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('full_address')
                                            ->columnSpanFull(),
                                        TextEntry::make('address'),
                                        TextEntry::make('city'),
                                        TextEntry::make('state'),
                                        TextEntry::make('zip_code'),
                                    ]),
                                Section::make('Features')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('stories')
                                            ->numeric(),
                                        IconEntry::make('has_basement')
                                            ->boolean(),
                                        IconEntry::make('basement_finished')
                                            ->boolean(),
                                        TextEntry::make('bedrooms')
                                            ->numeric(),
                                        TextEntry::make('bathrooms')
                                            ->numeric(),
                                        TextEntry::make('square_feet')
                                            ->numeric(),
                                        IconEntry::make('parking')
                                            ->boolean(),
                                        IconEntry::make('pets_allowed')
                                            ->boolean(),
                                        TextEntry::make('other')
                                            ->columnSpanFull(),
                                    ]),
                                Section::make('Timestamps')->schema([
                                    TextEntry::make('created_at')
                                        ->dateTime('M d, Y h:i A T'),
                                    TextEntry::make('updated_at')
                                        ->dateTime('M d, Y h:i A T'),
                                ]),
                            ]),
                        Tab::make('Owner Information')
                            ->columns(1)
                            ->schema([
                                Section::make('Basic Information')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('owner.name')
                                            ->label('Name'),
                                        TextEntry::make('owner.email')
                                            ->label('Email'),
                                        TextEntry::make('owner.formatted_phone')
                                            ->label('Phone'),
                                    ]),
                                Section::make('Address')
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('owner.full_address')
                                            ->label('Full Address')
                                            ->columnSpanFull(),
                                        TextEntry::make('owner.address')
                                            ->label('Address'),
                                        TextEntry::make('owner.city')
                                            ->label('City'),
                                        TextEntry::make('owner.state')
                                            ->label('State'),
                                        TextEntry::make('owner.zip_code')
                                            ->label('Zip Code'),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
