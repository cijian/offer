<?php

namespace App\Http\Controllers\API;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Get Article list
     */
    public function index()
    {
//        return response(Article::all());
        return response()->json(Article::where(['is_del'=>0])->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = new Article;
        $message = ['status'=>0];

//        $content = $request->input('content');
        if(empty($request->title)||empty($request->content)||empty($request->author)||empty($request->comment)){
            return response($message);
        }

        $article->title = $request->title;
        $article->content = $request->content;
        $article->author = $request->author;
        $article->comment = $request->comment;
        $article->publish_time = Carbon::now()->toDateTimeString();;

        if($article->save()){
            $message['status'] = 1;
        }

        return response($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return article data
     */
    public function show($id)
    {
        $data = Article::where(['is_del'=>0])->findOrFail($id);
        return response()->json($data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * @param string $keyword
     * @return Article date list
     */
    public function search($keyword){

        if(empty($keyword)) return response('',404);

        $commentWorld = ['comment_content','author'];
        $articleWorld = ['title','content','author','comment'];
        $map['is_del'] = 0;

        $commentSearch = $this->complieSearchArray($commentWorld,$keyword);
        $articleSearch = $this->complieSearchArray($articleWorld,$keyword);

        $commentData = Comment::when($commentSearch,function($query) use ($commentSearch) {
            foreach ($commentSearch as $key=>$value){
                $query->orWhere($key,'like',$value);
            }
            return $query;
        })->where($map)->groupBy('aid')->pluck('aid')->toArray();



        $article = Article::when($articleSearch,function($query) use ($articleSearch) {
            foreach ($articleSearch as $key=>$value){
                $query->orWhere($key,'like',$value);
            }
            return $query;
        })->where($map);

        empty($commentData) || $article = $article->orWhereIn('id',$commentData);

        $articleData = $article->get()->toArray();

        return response()->json($articleData);

    }


    /**
     * merge search world in array；
     */
    public function complieSearchArray($worldArr,$keyword){

        foreach ($worldArr as $v) {
            $search[$v] = ['%'.$keyword.'%'];
        }

        return $search;
    }

}
