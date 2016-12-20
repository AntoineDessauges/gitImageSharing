<?php

namespace App\Http\Controllers;

use App\Image;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth",["except"=>["welcome"]]);
    }
    public function welcome(Request $request)
    {
        return view("welcome",['images'=>Image::lastTen()->get()]);
    }
    public function home(Request $request)
    {
        return view("home",["user"=>Auth::user(),'images'=>Image::lastTen()->where("user_id","!=",$request->user()->id)->get(),'myImages'=>Image::lastTen()->where("user_id",$request->user()->id)->get()]);
    }

}
