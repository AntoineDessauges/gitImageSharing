<form class="" action="{{ route('image.update',$img) }}" method="post">
  {{ method_field("PUT") }}
  {{ csrf_field() }}
  <h2>Edit Image <small>{{$img->original_filename}}</small></h2>
  <img class="img-thumbnail" src="{!! $img->thumbnail_url !!}" alt="{{$img->original_filename}}"/>
  <select class="form-control" name="album">

    @foreach($albums as $al)
      <option value="{{$al->id}}" {{ $al->id == $img->album()->first()->id ?"selected":"" }}>{{$al->name}}</option>
    @endforeach
  </select>
  <div class="btn-group">
    <input class="btn btn-primary" type="submit" name="edit_image" value="Update">
    <a href="#" data-href="{{ route("image.destroy",$img) }}" data-confirm="Are you sure you want to delete this superbe image?" type="button" class="btn btn-danger">Delete</a>

  </div>

</form>

