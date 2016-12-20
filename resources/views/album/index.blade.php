@extends('layouts.lambda')

@section('innercnt')
  @include('partials.album.list',['albums'=>$albums])

@endsection
