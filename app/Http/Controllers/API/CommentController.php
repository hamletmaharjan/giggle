<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Comment as CommentResource;
use App\Events\Commented;
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
      event(new Commented($comment));

    }

    public function show($id) {
      $comment = Comment::findOrFail($id);
      return new CommentResource($comment);
    }



    public function update(Request $request,$id) {
      $comment = Comment::findOrFail($id);
      $user = Auth::user();
      if($user->can('update',$comment)) {
        $comment->comment = $request['comment'];
        $comment->save();
        return response()->json([
            'message'=>'success'
        ]);
      }
      else {
        return response()->json([
            'message'=>'Unauthorized'
        ]);
      }
    }

    public function destroy($id) {
      $comment = Comment::findOrFail($id);
      $user = Auth::user();
      if($user->can('delete',$comment)) {
        $comment->delete();
        return response()->json([
            'message'=>'Comment Deleted'
        ]);
      }
      else {
        return response()->json([
            'message'=>'Unauthorized to delete comment'
        ]);
      }
    }
}
