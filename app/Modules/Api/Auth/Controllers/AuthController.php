<?php

declare(strict_types=1);

namespace App\Modules\Api\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Api\Auth\Requests\AuthLoginRequest;
use App\Modules\Api\Auth\Requests\AuthRegisterRequest;
use App\Modules\Core\ORM\Managers\Contracts\UserManagerContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * @param  UserManagerContract  $userManager
     */
    public function __construct(
        readonly private UserManagerContract $userManager
    ) {
    }

    /**
     * @param  AuthLoginRequest  $request
     *
     * @return JsonResponse
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        if ( ! $token = auth()->attempt($request->validated())) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @param  AuthRegisterRequest  $request
     *
     * @return JsonResponse
     */
    public function register(AuthRegisterRequest $request): JsonResponse
    {
        $user = $this->userManager->create(
            $request->get('name'), $request->get('password')
        );

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User successfully registered',
            'user'    => $user,
            'token'   => $token,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getUser(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * @param $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60,
        ]);
    }
}
