<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('User Information')
                    ->columns()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->password()
                            ->required(),
                        TextInput::make('phone')
                            ->tel(),
                    ]),
                Section::make('Address')
                    ->columns()
                    ->schema([
                        Textarea::make('full_address')
                            ->columnSpanFull(),
                        TextInput::make('address'),
                        TextInput::make('city'),
                        TextInput::make('state'),
                        TextInput::make('zip_code'),
                    ]),
            ]);
    }
}
