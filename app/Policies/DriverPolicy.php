<?php

namespace App\Policies;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DriverPolicy
{
    
    use HandlesAuthorization;
      /**
     * Determine whether the user can index models.
     */
    public function index(User $user): bool
    {
        return $user->role->name === 'مدير';
    }
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->name === 'مدير';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Driver $driver): bool
    {
        return $user->role->name === 'مدير';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Driver $driver): bool
    {
        return $user->role->name === 'مدير';
    }

    public function MultiDelete(User $user): bool
    {
        return $user->role->name === 'مدير';
    }
    
}
