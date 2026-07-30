<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PerformanceImprovementPlan;

class PerformanceImprovementPlanPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, PerformanceImprovementPlan $model): bool
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

    public function update(User $user, PerformanceImprovementPlan $model): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->isCoach()) {
            return $model->user && $model->user->manager_id === $user->id;
        }
        return $model->user_id === $user->id;
    }

    public function delete(User $user, PerformanceImprovementPlan $model): bool
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
