<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Upvote;

class UpvoteController extends Controller
{
    public function upvote(Request $request) {
      $upvote = Upvote::where([
        ['user_id','=',Auth::user()->id],
        ['article_id','=',$request['article_id']],
      ])->first();



      if($upvote) {
        $upvote->delete();
        return 'unvoted';
      }
      else {
        $upvote = new Upvote();
        $upvote->user_id = Auth::user()->id;
        $upvote->article_id = $request['article_id'];
        $upvote->save();
        return 'upvoted';
      }

    }

    public function removeUpvote(Request $request) {
      return $request;
    }
}
