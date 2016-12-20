@extends('layouts.app')

@section('content')

<div class="container">
    @if(isset($myImages))
        <div class="row">
            <h1>My images</h1>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                @include("partials.image.list",["images"=>$myImages])
            </div>
        </div>
    @endif

    @if(isset($images) && $images->count()>0)
        <div class="row">
            <h1>Latest website images</h1>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                @include("partials.image.list",compact("images"))
            </div>
        </div>

    @endif

</div>
@endsection
