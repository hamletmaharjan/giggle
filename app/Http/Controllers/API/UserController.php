<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
