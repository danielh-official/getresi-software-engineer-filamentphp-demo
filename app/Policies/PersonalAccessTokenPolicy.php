<?php

namespace App\Policies;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class PersonalAccessTokenPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view a personal access token');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PersonalAccessToken $personalAccessToken): bool
    {
        return $user->hasPermissionTo('view a personal access token');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create personal access tokens');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PersonalAccessToken $personalAccessToken): bool
    {
        return $user->hasPermissionTo('update personal access tokens');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PersonalAccessToken $personalAccessToken): bool
    {
        return $user->hasPermissionTo('delete personal access tokens');
    }
}
