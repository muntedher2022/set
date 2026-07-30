<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SwotAnalysis;

class SwotAnalysisPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SwotAnalysis $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->isCoach()) {
            return $model->scope === 'institutional' || ($model->user && $model->user->manager_id === $user->id);
        }
        return $model->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return !$user->isEmployee();
    }

    public function update(User $user, SwotAnalysis $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->isCoach()) {
            return $model->scope === 'institutional' || ($model->user && $model->user->manager_id === $user->id);
        }
        return false;
    }

    public function delete(User $user, SwotAnalysis $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->isCoach()) {
            return $model->scope === 'institutional' || ($model->user && $model->user->manager_id === $user->id);
        }
        return false;
    }
}
