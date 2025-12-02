<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser /**, MustVerifyEmail*/
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'full_address',
        'address',
        'city',
        'state',
        'zip_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function properties(): Builder|HasMany
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    public function formattedPhone(): Attribute
    {
        return Attribute::make(
            get: fn () => preg_replace(
                '/(\d{3})(\d{3})(\d{4})/',
                '($1) $2-$3',
                $this->phone,
            ),
        );
    }

    public function emailIsVerified(): Attribute
    {
        return Attribute::make(
            get: fn () => filled($this->email_verified_at),
        );
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasPermissionTo('access admin panel') && $this->email_is_verified;
    }
}
