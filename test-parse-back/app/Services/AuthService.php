<?php

namespace App\Services;

use App\Models\Row;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService {

    protected $row;

    public function __construct(Row $row)
    {
        $this->row = $row;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(object $request) : object
    {
        $user = User::whereName($request->name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'messages' => [
                    __('auth.name_does_not_exists')
                ]
            ], 403);
        }

        $token = auth('api')->attempt(
            $request->only([
                'name',
                'password'
            ])
        );

        if (!$token) {
            return response()->json([
                'success' => false,
                'messages' => [
                    __('auth.login_failed')
                ]
            ], 401);
        }

        return $this->respondWithToken($token, $request->remember_me);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() : object
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token) : object
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}



