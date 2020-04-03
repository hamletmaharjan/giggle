<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Support\Facades\Storage;

class Article extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => Storage::url('public/articles/'.$this->image),
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'comments' => CommentResource::collection($this->comments),
            'upvotes' => $this->upvotes->count(),

        ];
    }
}
