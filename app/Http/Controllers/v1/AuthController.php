<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Authenticate user and return token
     *
     * @param AuthRequest $request
     * @return JsonResponse
     */
    public function login(AuthRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthenticated.',
                'errors' => [
                    'email' => ['Invalid login credentials.']
                ]
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'access_token' => $this->generateToken(),
            'token_type' => 'Bearer',
        ], Response::HTTP_OK);
    }

    /**
     *
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user?->tokens()->where('id', $user->currentAccessToken()->id)->delete();

        return response()->json([
            'message' => 'User logged out successfully.'
        ], Response::HTTP_OK);
    }

    /**
     * Generate token for login user.
     *
     * @return mixed
     */
    private function generateToken(): mixed
    {
        $user = Auth::user();
        if ($user->tokens()->count()) {
            $user->tokens()->delete();
        }
        return $user->createToken('api-token')->plainTextToken;
    }
}
