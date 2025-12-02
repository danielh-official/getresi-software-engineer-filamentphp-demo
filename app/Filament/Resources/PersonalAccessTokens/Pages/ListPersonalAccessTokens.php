<?php

namespace App\Filament\Resources\PersonalAccessTokens\Pages;

use App\Filament\Resources\PersonalAccessTokens\PersonalAccessTokenResource;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Laravel\Sanctum\PersonalAccessToken;

class ListPersonalAccessTokens extends ListRecords
{
    protected static string $resource = PersonalAccessTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->successNotificationTitle(null)
                ->createAnother(false)
                ->using(function (array $data): ?Model {

                    /** @disregard intelephense(P1013) */
                    $currentUser = auth()->user();

                    if (empty($currentUser)) {
                        throw new \RuntimeException('No authenticated user found.');
                    }

                    $token = $currentUser->createToken(
                        name: $data['name'],
                        abilities: ['*'],
                        expiresAt: $data['expires_at'] ?? null,
                    );

                    Notification::make()
                        ->icon('heroicon-o-key')
                        ->body(new HtmlString(
                            'Personal Access Token created successfully. '.
                            'Please copy and store the token securely now, as it will not be shown again.<br><br>'.
                            '<code class="p-2 bg-gray-100 rounded text-sm">'.e($token->plainTextToken).'</code>'
                        ))
                        ->success()
                        ->title('Personal Access Token Created')
                        ->send();

                    return PersonalAccessToken::findToken($token->plainTextToken);
                }),
        ];
    }
}
