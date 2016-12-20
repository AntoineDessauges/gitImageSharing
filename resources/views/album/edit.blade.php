@extends('layouts.lambda')

@section('innercnt')
  @include('partials.album.edit_form',['al'=>$album])
@endsection
