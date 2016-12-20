@extends('layouts.app')

@section('content')

  <div class="container">
      @if($errors->any())
          <div class="row">
              <div class="alert alert-danger" role="alert">
                  <ul>
                      @foreach ($errors->all() as $message)
                          <li>{{ $message }}</li>
                      @endforeach
                  </ul>
              </div>
          </div>
      @endif
      @if (session('message'))
          <div class="alert alert-success">
              {{ session('message') }}
          </div>
      @endif
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
              @yield('innercnt')
          </div>
      </div>
  </div>
@endsection
