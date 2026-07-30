<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GrowSession;

class GrowSessionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, GrowSession $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->isCoach()) {
            return $model->user && $model->user->manager_id === $user->id;
        }
        return $model->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return !$user->isEmployee();
    }

    public function update(User $user, GrowSession $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->isCoach()) {
            return $model->user && $model->user->manager_id === $user->id;
        }
        return false;
    }

    public function delete(User $user, GrowSession $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->isCoach()) {
            return $model->user && $model->user->manager_id === $user->id;
        }
        return false;
    }
}
