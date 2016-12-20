@extends('layouts.lambda')

@section('innercnt')
  @include('partials.image.list',['images'=>$images])

@endsection
