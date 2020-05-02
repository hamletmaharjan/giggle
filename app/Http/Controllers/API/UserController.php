<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Article as ArticleResource;
use App\User;

class UserController extends Controller
{
    public function index() {
      $user = User::all();
      return response()->json($user);
    }


    public function show($username) {
      $user = User::where('username','=',$username)->first();
      return response()->json($user);
    }

    public function articles($username) {
      $user = User::where('username','=',$username)->first();
      $articles = $user->articles;
      return ArticleResource::collection($articles);
    }

    public function me()
    {
      $user = Auth::user();
      return response()->json($user);
    }

    public function test(Request $request) {
      return $request;
    }

    public function changePassword(Request $request){
        if (Hash::check($request['old_password'], Auth::user()->password)) {

            $request->validate([
                'new_password' => ['required', 'string', 'min:8'],
                'confirm_password' => ['same:new_password']
            ]);

            if(Hash::check($request['new_password'],Auth::user()->password)){
                return response()->json([
                  'message'=>'New Password Cannot be same as old'
                ]);
            }

            $user = Auth::user();
            $user->password = Hash::make($request['new_password']);
            $user->save();
            return response()->json([
              'message' => 'Password Changed'
            ]);
        }
        else{
            return response()->json([
              'message' => 'Invalid Password'
            ]);
        }

    }
}
