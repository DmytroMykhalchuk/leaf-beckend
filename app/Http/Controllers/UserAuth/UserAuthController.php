<?php

namespace App\Http\Controllers\UserAuth;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Profile\InitProfileResource;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends BaseController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $data = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully fetched',
            'data' => new InitProfileResource(auth()->user()),
        ];

        return $this->formatResponse($data);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return [
            'code' => 200,
            'status' => 'success',
            'message' => 'Successfully refreshed',
            'data' => [],
            'authorization' => [
                'token' => Auth::refresh(),
            ],
        ];
    }
}
