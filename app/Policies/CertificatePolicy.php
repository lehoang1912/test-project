<?php

namespace App\Policies;

use App\Models\Certificate;
use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CertificatePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role == User::ROLE_ADMIN) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Job  $job
     * @return bool
     */
    public function create(User $user, Job $job)
    {
        return $job->user_id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Certificate  $certificate
     * @param  \App\Models\Job  $job
     * @return mixed
     */
    public function delete(User $user, Certificate $certificate, Job $job)
    {
        return $certificate->job_id == $job->id && $job->user_id == $user->id;
    }
}
