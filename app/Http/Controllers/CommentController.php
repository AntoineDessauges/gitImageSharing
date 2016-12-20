<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CreateCommentRequest;
use App\Image;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Image $image
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,Image $image)
    {
        return view("image.show",compact("image"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Image $image
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCommentRequest $request, Image $image)
    {
        $comment = new Comment($request->except("_token","_method"));
        $comment->user_id = \Auth::user()->id;
        $comment->image_id = $image->id;
        if($request->has("parent")){
            $comment->parent_id = Comment::findOrFail($request->get("parent"))->id;
        }
        $comment->save();
        if($request->ajax())
            return $comment;
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Comment $comment)
    {
        return view("comment.show",compact("comment"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(403);
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
