<div class="col-md-4">
  <a href="{!! isset($raw) ? $img->url : route("image.show",$img) !!}" class="thumbnail" style="margin-bottom:2px"><img class="img-responsive img-thumbnail" src="{!! getS3URL('ADSF/'.$img->filename) !!}" alt="{{{$img->original_filename}}}"/></a>
  <div class="caption">
    <p class="small text-center center-block hidden-sm" style="text-overflow:ellipsis;">uploaded {{ $img->created_at->diffForHumans() }} </p>
    @if(\Auth::check() && $img->user->id == \Auth::user()->id)
      <div class="btn-group btn-group-sm" role="group" aria-label="...">
        <a href="{{ route("image.edit",$img) }}" type="button" class="btn btn-info">Edit</a>
        <a href="{{ route("image.destroy",$img) }}" data-method="delete" data-confirm="Are you sure you want to delete this superbe image?" type="button" class="btn btn-danger">Delete</a>
      </div>
    @endif
    @if(\Auth::check())

      @include('partials.comment.form',["image"=>$img])
    @endif
    @include('partials.comment.list',["comments"=>$img->comments()->where("parent_id",null)->get()])

  </div>
</div>
