@extends('layouts.lambda')

@section('innercnt')
    <div class="row">
        <div class="col-md-1 col-md-push-0 col-xs-2 col-xs-push-3">
            <h1>{{ $album->name }}</h1>
        </div>
        <div class="col-md-1 col-md-push-1 col-xs-1 col-xs-push-5">
            <h1><a href="{{ route("album.edit",$album) }}" class="btn btn-default">Edit</a></h1>
        </div>

    </div>
    <div class="row">
        <p>{{ $album->description }}</p>
    </div>
    <div class="row">
        @include("partials.image.list",["images"=>$album->images()->get()])
    </div>


@endsection
