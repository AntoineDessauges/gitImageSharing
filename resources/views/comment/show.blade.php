@extends('layouts.lambda')

@section('innercnt')
    {{ dd($image) }}
  @include('partials.comment.item',compact("image","comment"))
@endsection
