@extends('layouts.lambda')

@section('innercnt')
  @include('partials.image.show',['img'=>$image,"raw"=>true])
@endsection
