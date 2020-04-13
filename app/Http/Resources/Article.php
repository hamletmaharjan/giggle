<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Upvote;

class Article extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */


     public function isUpvoted($upvoted){
       if($upvoted){
         return true;
       }
       else {
         return false;
       }
     }

    public function toArray($request)
    {
        $upvote = Upvote::where([
          ['user_id','=',Auth::user()->id],
          ['article_id','=',$this->id],
        ])->first();



        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => Storage::url('public/articles/'.$this->image),
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'comments' => $this->comments->count(),
            'upvotes' => $this->upvotes->count(),
            'is_upvoted' => self::isUpvoted($upvote),
            'is_self' => ($this->user->id == Auth::user()->id)? true : false,

        ];
    }
}
