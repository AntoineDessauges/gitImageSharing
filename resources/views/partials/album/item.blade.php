<div class="panel panel-default">
    <div class="panel-heading">
      <span tabindex="0" data-placement="bottom" data-toggle="popover" role="button" class="popOver" data-toggle="popover" data-trigger="hover" title="Description" data-content="{{$al->description}}">
        <a href="{{ route("album.show",$al) }}">{{$al->name}}</a>
      </span>
      <span>Last updated : {{ $al->updated_at }}</span>
    </div>
    <div class="panel-body">
        @include('partials.image.list',['images'=>$al->images()->get()])
    </div>
</div>
