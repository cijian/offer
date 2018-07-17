<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new Comment;
        $message = ['status'=>0];

        if(empty($request->aid)||empty($request->comment_content)||empty($request->author)){
            return response($message);
        }

        $comment->aid = $request->aid;
        $comment->comment_content = $request->comment_content;
        $comment->author = $request->author;
        $comment->comment_time = Carbon::now()->toDateTimeString();;

        if($comment->save()){
            $message['status'] = 1;
        }

        return response($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id (article_id)
     * @return comment list by article
     */
    public function show($id)
    {

        if(!is_numeric($id) || intval($id)<=0) return response('','404');

        return response()->json(Article::where(['is_del'=>0])->find($id)->getCommentListByArticle);

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
}
