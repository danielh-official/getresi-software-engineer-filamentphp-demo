<?php

namespace App\Providers;

use App\Policies\PersonalAccessTokenPolicy;
use App\Policies\RolePolicy;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Role;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        TextEntry::configureUsing(static function (TextEntry $field): void {
            $field->placeholder('-');
        });

        TextColumn::configureUsing(static function (TextColumn $column): void {
            $column->placeholder('-');
        });

        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(PersonalAccessToken::class, PersonalAccessTokenPolicy::class);
    }
}
