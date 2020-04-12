<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\ArticleDetail as ArticalDetailResource;
use App\Http\Resources\ArticleCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\ImageServices;
use App\Article;

class ArticleController extends Controller
{
    protected $imageServices;
    public function __construct(ImageServices $imageServices){
        $this->imageServices = $imageServices;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('type')){
          if($request->type == 'mu'){
            $articles = DB::table('upvotes')
                              ->join('articles','upvotes.article_id','=','articles.id')
                              ->select(DB::raw('count(upvotes.article_id) as upvotes'),'articles.*')
                              ->groupBy('upvotes.article_id')
                              ->orderByRaw('count(upvotes.article_id) desc')
                              ->paginate(5);

            return response()->json([
              'data' => $articles
            ]);
          }
        }
        //return Article::all();
        // if($request->has('type')
        return new ArticleCollection(Article::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $id =  Auth::user()->id;
        $article = new Article();
        $article->title = $request['title'];
        $article->description = $request['description'];
        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = $this->imageServices->moveImageWithName($image);
            $article->image = $imageName;
        }
        $article->user_id = $id;
        $article->save();
        return response()->json([
            'message'=>'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Article::find($id);
        return new ArticalDetailResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = Article::find($id);
        $article->title = $request['title'];
        $article->description = $request['description'];
        $article->image = $request['image'];
        $article->save();
        return response()->json([
            'message'=>'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::find($id);
        if($this->imageServices->deleteArticle($article->image)){
            if($article->delete()){
                return response()->json([
                    'message'=>'Deleted'
                ]);
            }
        }
        else{
            return response()->json([
                'message'=>'Delete failed'
            ]);
        }

    }

  public function mostUpvoted() {
      $articles = DB::table('upvotes')
                        ->join('articles','upvotes.article_id','=','articles.id')
                        ->select(DB::raw('count(upvotes.article_id) as upvotes'),'articles.*')
                        ->groupBy('upvotes.article_id')
                        ->orderByRaw('count(upvotes.article_id) desc')
                        ->get();

      return $articles;
    }

}
