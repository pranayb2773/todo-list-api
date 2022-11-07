<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Tags;
use App\Models\TodoList;
use App\Models\User;
use App\Policies\v1\TagPolicy;
use App\Policies\v1\TodoListPolicy;
use App\Policies\v1\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Tags::class => TagPolicy::class,
        TodoList::class => TodoListPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Give all access to admin user.
        Gate::before(function (User $user, $ability) {
            if ($user->is_admin) {
                return true;
            }
        });

        Gate::define('viewUserTodoLists', function (User $user, User $model) {
            return $user->id === $model->id;
        });
        Gate::define('viewUserTodoList', function (User $user, TodoList $model) {
            return $user->id === $model->user_id;
        });
        Gate::define('createUserTodoLists', function (User $user, User $model) {
            return $user->id === $model->id;
        });
        Gate::define('updateUserTodoList', function (User $user, TodoList $model) {
            return $user->id === $model->user_id;
        });
        Gate::define('deleteUserTodoList', function (User $user, TodoList $model) {
            return $user->id === $model->user_id;
        });
    }
}
