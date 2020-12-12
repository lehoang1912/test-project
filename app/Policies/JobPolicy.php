<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role == User::ROLE_ADMIN) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job   $job
     * @return bool
     */
    public function update(User $user, Job $job)
    {
        return $job->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job   $job
     * @return bool
     */
    public function delete(User $user, Job $job)
    {
        return $job->user_id == $user->id;
    }
}
