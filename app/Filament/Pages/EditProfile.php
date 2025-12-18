<?php

namespace App\Filament\Pages;

use Filament\Auth\Pages\EditProfile as OriginalEditProfile;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class EditProfile extends OriginalEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                $this->getCurrentPasswordFormComponent(),
                Select::make('timezone')
                    ->searchable()
                    ->required()
                    ->placeholder('Select your timezone')
                    ->options(collect(\DateTimeZone::listIdentifiers())->mapWithKeys(fn ($tz) => [$tz => $tz])->toArray())
                    ->label('Timezone'),
            ]);
    }
}
