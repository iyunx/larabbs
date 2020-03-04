<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before($user, $ability)
	{
	    if ($user->can('manage_contents')) {
	    	return true;
	    }
	}

    public function update(User $user, User $currentUser)
    {
        return $user->id === $currentUser->id;
    }
}
