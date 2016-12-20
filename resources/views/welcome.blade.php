@extends('layouts.app')

@section('content')
            <div class="container content">
                <h1>The latest images</h1>
                <div class="row">
                    <div class="col-md-8 col-md-push-2">
                        @include("partials.image.list",$images)
                    </div>
                </div>
            </div>
@endsection