<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('User Information')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->placeholder('-'),
                        TextEntry::make('email')
                            ->placeholder('-'),
                        TextEntry::make('phone')
                            ->placeholder('-'),
                    ]),
                Section::make('Address')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('full_address')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('address')
                            ->placeholder('-'),
                        TextEntry::make('city')
                            ->placeholder('-'),
                        TextEntry::make('state')
                            ->placeholder('-'),
                        TextEntry::make('zip_code')
                            ->placeholder('-'),
                    ]),
                Section::make('Timestamps')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created at')
                            ->dateTime('M d, Y H:i:s')
                            ->disabled(),
                        TextEntry::make('updated_at')
                            ->label('Last updated at')
                            ->dateTime('M d, Y H:i:s')
                            ->disabled(),
                    ]),
            ]);
    }
}
