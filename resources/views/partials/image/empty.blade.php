@if(\Auth::check())
Yo, you got no images. Upload some at <a href="{{ route("image.create") }}">right over here</a>
@endif
