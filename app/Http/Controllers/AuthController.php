<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function signup(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|between:8,255|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'username' => $request->username,
            'gender'  => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'bio' => $request->bio
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
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
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials)){
            return response()->json([
                'message' => 'Login Failed'
            ], 401);
        }



        $user =  Auth::user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $tokenResult->token->expires_at,
            'user_data'=> $user
        ]);
        // return response()->json([
        //     'access_token' => $tokenResult->accessToken,
        //     'token_type' => 'Bearer',
        //     'expires_at' => Carbon::parse(
        //         $tokenResult->token->expires_at
        //     )->toDateTimeString(),
        //     'user_data'=> $user
        // ]);


        // $user = $request->user();
        // $tokenResult = $user->createToken('Personal Access Token');
        // $token = $tokenResult->token;
        // if ($request->remember_me)
        //     $token->expires_at = Carbon::now()->addWeeks(1);
        // $token->save();
        // return response()->json([
        //     'access_token' => $tokenResult->accessToken,
        //     'token_type' => 'Bearer',
        //     'expires_at' => Carbon::parse(
        //         $tokenResult->token->expires_at
        //     )->toDateTimeString()
        // ]);
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
