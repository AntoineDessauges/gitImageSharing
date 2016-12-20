
@extends('layouts.lambda')

@section('innercnt')
  @include('partials.image.upload',['albums'=>Auth::user()->albums()->get()])
@endsection
