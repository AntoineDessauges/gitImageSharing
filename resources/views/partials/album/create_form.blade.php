<form class="" action="{{ route('album.store') }}" method="post">
  <h2>Create Album</h2>
  <div class="input-group">
    <span class="input-group-addon">Name</span>
    <input class="form-control" type="text" name="name" value="" placeholder="album name">
  </div>
  {{ csrf_field() }}
  <textarea class="form-control" name="description" placeholder="album desc"></textarea>
  <input class="btn btn-primary" type="submit" name="create_album" value="Create">
</form>
