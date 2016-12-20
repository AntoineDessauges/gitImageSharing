<?php

namespace App\Http\Controllers;

use App\Album;
use App\Events\ImageDeletedEvent;
use App\Http\Requests\CreateImageRequest;
use App\Jobs\CreateThumbnail;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Image;
use App\Lib\ImageManipulation;
use Storage;
class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth",["except"=>["thumbnail"]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return view("image.index",["images"=>$request->user()->images()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $s3FormDetails = getS3Details(env('S3_BUCKET'), 'eu-west-1');
        return view('image.create', compact('s3FormDetails'));
    }

    /**
     * Should never come here, moved to UploadController@upload
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateImageRequest $request)
    {
        return abort(403);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return view("image.show",compact("image"));
    }

    /**
     * Returns the image content from data
     * @param Image $image
     */
    public function raw(Image $image)
    {
        return response()->file($image->path);
        abort(404);//not found
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Image $image)
    {
        if(!$this->checkUserOnModel($image))
            abort(403);
        $albums = Album::where("user_id",$request->user()->id)->get();
        return view('image.edit',compact("albums","image"));
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
        return abort(403,"you should have never came here");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {

        if(!$this->checkUserOnModel($image))
            abort(403);
        $image->delete();
        event(new ImageDeletedEvent($image->path));
        return redirect()->to("/image");
    }

    /**
     * Generates a thumbnail for an image
     * @param Request $request
     * @param Image $image
     * @return mixed
     */
    public function thumbnail(Request $request, Image $image)
    {
        //dd($image->url);
        $path = false;

        $pathToThumbnail = ImageManipulation::thumbnailName($image->path);
        if(Storage::exists($pathToThumbnail)){
          $path = $pathToThumbnail;
        }
        else{
          $path = ImageManipulation::createThumbnail($image->path);
        }

        if(!$path)
          abort(404);
        return response()->file($path);
    }


   
}
