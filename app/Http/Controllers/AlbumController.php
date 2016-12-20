<?php

namespace App\Http\Controllers;

use App\Album;
use App\Http\Requests\CreateAlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('album.index',["albums"=>$request->user()->albums()->get()]);//list all albums
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('album.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAlbumRequest $request)
    {
        $album = new Album($request->all());
        $album->user_id = $request->user()->id;
        try{
            $album->save();
        }
        catch(QueryException $e){
            return redirect()->back()->withErrors(["msg"=>"The album already exists"]);
        }
        return redirect()->to("/album/{$album->id}")->with("message","Album added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        return view("album.show", ["album"=>$album]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        return view("album.edit",["album"=>$album]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlbumRequest $request, Album $album)
    {
        if(!$this->checkUserOnModel($album))
            return abort(403);
        $album->update($request->all());
        return redirect()->back()->with("message","Album updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        if(!$this->checkUserOnModel($album))
            abort(403);
        $name = $album->name;
        $album->delete();
        return redirect()->to("/album")->with("message","Album {$name} destroyed...");
    }
}
