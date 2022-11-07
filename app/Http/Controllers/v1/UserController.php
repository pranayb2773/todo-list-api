<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CreateUserRequest;
use App\Http\Requests\v1\UpdateUserRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    /**
     * Get list of users.
     *
     * @return AnonymousResourceCollection | JsonResponse
     * @throws AuthorizationException
     */
    public function index(): AnonymousResourceCollection | JsonResponse
    {
            $this->authorize('viewAny');

            $users = User::query();
            return UserResource::collection($users->paginate());
    }


    /**
     * Get the details of user.
     *
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(User $user): JsonResponse
    {
        $this->authorize('view', $user);

        return response()->json([
            'data' => UserResource::make($user)
        ], Response::HTTP_OK);
    }


    /**
     * Create new user.
     *
     * @param CreateUserRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'is_admin' => $request->input('is_admin'),
        ]);

        return response()->json([
            'message' => 'New user added successfully.',
            'data' => UserResource::make($user)
        ], Response::HTTP_CREATED);
    }


    /**
     * Update existing user info.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', $user);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'is_admin' => $request->input('is_admin'),
        ]);

        return response()->json([
            'message' => 'User details updated successfully.',
            'data' => UserResource::make($user)
        ], Response::HTTP_OK);
    }

    /**
     * Delete user.
     *
     * @param User $user
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully.',
        ], Response::HTTP_OK);
    }
}
