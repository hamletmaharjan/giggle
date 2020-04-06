<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Comment as CommentResource;
use App\Comment;

class CommentController extends Controller
{
    public function index($id) {
      $comments = Comment::where('article_id','=',$id)->get();
      return CommentResource::collection($comments);
    }

    public function store(Request $request,$id) {
      $comment = new Comment();
      $comment->comment = $request['comment'];
      $comment->user_id = Auth::user()->id;
      $comment->article_id = $id;
      $comment->save();
      return response()->json([
          'message'=>'success'
      ]);
    }


    public function update(Request $request,$id) {

    }

    public function delete($id) {

    }
}
