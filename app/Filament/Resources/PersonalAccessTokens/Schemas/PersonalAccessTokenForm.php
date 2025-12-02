<?php

namespace App\Filament\Resources\PersonalAccessTokens\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PersonalAccessTokenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('expires_at')
                    ->minDate(now())
                    ->nullable()
                    ->helperText('If left empty, the token will not expire.')
                    ->visibleOn('create'),
            ]);
    }
}
