<?php

namespace App\Policies;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActivityLogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ActivityLog  $activityLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ActivityLog $activityLog)
    {
        return $user->id === $activityLog->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ActivityLog  $activityLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ActivityLog $activityLog)
    {
        return $user->id === $activityLog->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ActivityLog  $activityLog
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ActivityLog $activityLog)
    {
        return $user->id === $activityLog->user_id;
    }
}
