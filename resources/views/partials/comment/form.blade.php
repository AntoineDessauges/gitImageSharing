<div class="row">
    @if(isset($comment))
        <form class="" action="{{ route('image.comment.store',$comment->image) }}" method="post">
        <input type="hidden" name="parent" value="{{ $comment->id }}">
    @else
        <form class="" action="{{ route('image.comment.store',$image) }}" method="post">
    @endif
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right:0px; padding-bottom:2px;">
                    <textarea class="form-control" style="resize: none; border-radius:2px; border: 2px solid #b1b1b1; width:100%;" name="text" placeholder="Comment"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-2  col-xs-push-10 col-md-push-7">
                    <input class="btn btn-primary" type="submit" name="update_album" value="Comment">
                </div>
            </div>
            {{ csrf_field() }}
        </form>
</div>

