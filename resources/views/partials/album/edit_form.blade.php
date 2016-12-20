<form class="" action="{{ route('album.update',$al) }}" method="post">
  {{ method_field('PATCH') }}
  <h2>Edit Album <small>{{ $al->name }}</small></h2>
  <div class="input-group">
    <span class="input-group-addon">Name</span>
    <input class="form-control" type="text" name="name" value="{{ $al->name }}" placeholder="album name">
  </div>
  {{ csrf_field() }}
  <textarea class="form-control" name="description" placeholder="album desc">{{{ $al->description }}}</textarea>
  <input class="btn btn-primary" type="submit" name="update_album" value="Update">
</form>
