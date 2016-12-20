@extends('layouts.lambda')

@section('innercnt')
  @include('partials.image.edit_form',['albums'=>$albums,'img'=>$image])
@endsection
