<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        try {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $user->save();
            return response()->json([
                'message' => 'Successfully created user!'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th
            ], 422);
        }
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);
        try {
            if (!Auth::attempt($credentials))
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addDays(3);
            $token->save();
            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th
            ], 422);
        }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
