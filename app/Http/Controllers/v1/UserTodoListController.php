<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CreateTodoListRequest;
use App\Http\Requests\v1\UpdateTodoListRequest;
use App\Http\Resources\v1\TodoListResource;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class UserTodoListController extends Controller
{
    /**
     * Get the todo-lists associated with the user.
     *
     * @param User $user
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(User $user): AnonymousResourceCollection
    {
        $this->authorize('viewUserTodoLists', $user);

        return TodoListResource::collection($user->todoLists()->with(['tags'])->paginate());
    }

    /**
     * Get the single todo-list associated with the user.
     *
     * @param User $user
     * @param TodoList $todoList
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(User $user, TodoList $todoList): JsonResponse
    {
        $this->authorize('viewUserTodoList', $todoList);

        return response()->json([
            'data' => TodoListResource::make($todoList)
        ], Response::HTTP_OK);
    }

    /**
     * Create a todo-list for user.
     *
     * @param CreateTodoListRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(CreateTodoListRequest $request, User $user): JsonResponse
    {
        $this->authorize('createUserTodoLists', $user);

       $todoList =  $user->todoLists()->create($request->except(['tags']));
       $todoList->tags()->attach($request->input('tags'));

       return response()->json([
           'message' => 'New todo-list created successfully.',
           'data' => TodoListResource::make($todoList)
       ], Response::HTTP_CREATED);
    }

    /**
     * Updated the todo-list associated with user.
     *
     * @param UpdateTodoListRequest $request
     * @param User $user
     * @param TodoList $todoList
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateTodoListRequest $request, User $user, TodoList $todoList): JsonResponse
    {
        $this->authorize('updateUserTodoList', $todoList);

        $todoList->update($request->except(['tags', 'user_id']));
        $todoList->tags()->sync($request->input('tags'));

        return response()->json([
            'message' => 'The todo-list updated successfully.',
            'data' => TodoListResource::make($todoList)
        ], Response::HTTP_OK);
    }

    /**
     * Delete the todo-list associated with the user.
     *
     * @param User $user
     * @param TodoList $todoList
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(User $user, TodoList $todoList): JsonResponse
    {
        $this->authorize('deleteUserTodoList', $todoList);

        $todoList->tags()->detach();
        $todoList->delete();

        return response()->json([
            'message' => 'The todo-list deleted successfully.',
        ], Response::HTTP_OK);
    }
}
