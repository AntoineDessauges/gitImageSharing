<div class="media">
  <div class="media-left" style="margin-left:20px;">
      <a href="{!! route("image.comment.show",["comment"=>$comment,"image"=>$comment->image]) !!}">
        <img style="width:36px;height:36px;" class="media-object" src="{!! url('/img/unknown.png') !!}" alt="avatar">
      </a>
  </div>
  <div class="media-body col-md-12">
    {{-- body --}}
    <h4 class="media-heading">{{ $comment->user->name }}</h4>
    <p class="media-body-content">
      {{ $comment->text }}
    </p>
    {{-- reply --}}
    <button class="btn btn-default" role="button" data-toggle="collapse" href="#reply-{{ $comment->id }}" aria-expanded="false" aria-controls="collapseExample">reply</button>
    <div class="collapse" id="reply-{{ $comment->id }}">
      <div class="well">
        @include("partials.comment.form",compact("comment"))
      </div>
    </div>
    {{-- children --}}
    @if($comment->children->count())
        @each('partials.comment.item', $comment->children, 'comment')
    @endif

    {{-- edit --}}
    @if(env("EDIT_COMMENT",false) && \Auth::check() && $img->user->id == \Auth::user()->id)
      <div class="btn-group btn-group-sm" role="group" aria-label="...">
        <a href="{{ route("comment.edit",$comment) }}" type="button" class="btn btn-info">Edit</a>
      </div>
    @endif

  </div>
</div>
