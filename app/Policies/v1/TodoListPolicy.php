<?php

namespace App\Policies\v1;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TodoListPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model
     *
     * @param User $user
     * @param TodoList $model
     * @return bool
     */
    public function view(User $user, TodoList $model): bool
    {
        return $user->id === $model->id;
    }
}
