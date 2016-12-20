<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else
                            <li><a href="{{url('/upload/image')}}">upload new image</a></li>
                            <li><a href="{{url('/album/create')}}">new album</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{url('/image')}}">My Images</a></li>
                                    <li><a href="{{url('/album')}}">My Albums</a></li>
                                    <li>

                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>

     <!-- Start of the JavaScript -->
        <!-- Load jQuery & jQuery UI (Needed for the FileUpload Plugin) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

        <!-- Load the FileUpload Plugin (more info @ https://github.com/blueimp/jQuery-File-Upload) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/blueimp-file-upload/9.5.7/jquery.fileupload.js"></script>

        <script>
            $(document).ready(function () {

                // Assigned to variable for later use.
                var form = $('.direct-upload');
                var filesUploaded = [];

                // Place any uploads within the descending folders
                // so ['test1', 'test2'] would become /test1/test2/filename
                var folders = [];

                form.fileupload({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    datatype: 'xml',
                    add: function (event, data) {

                        // Show warning message if your leaving the page during an upload.
                        window.onbeforeunload = function () {
                            return 'You have unsaved changes.';
                        };

                        // Give the file which is being uploaded it's current content-type (It doesn't retain it otherwise)
                        // and give it a unique name (so it won't overwrite anything already on s3).
                        var file = data.files[0];
                        var filename = Date.now() + '.' + file.name.split('.').pop();
                        form.find('input[name="Content-Type"]').val(file.type);
                        form.find('input[name="key"]').val((folders.length ? folders.join('/') + '/' : '') + filename);

                        // Actually submit to form to S3.
                        data.submit();

                        // Show the progress bar
                        // Uses the file size as a unique identifier
                        var bar = $('<div class="progress" data-mod="'+file.size+'"><div class="bar"></div></div>');
                        $('.progress-bar-area').append(bar);
                        bar.slideDown('fast');
                    },
                    progress: function (e, data) {
                        // This is what makes everything really cool, thanks to that callback
                        // you can now update the progress bar based on the upload progress.
                        var percent = Math.round((data.loaded / data.total) * 100);
                        $('.progress[data-mod="'+data.files[0].size+'"] .bar').css('width', percent + '%').html(percent+'%');
                    },
                    fail: function (e, data) {
                        // Remove the 'unsaved changes' message.
                        window.onbeforeunload = null;
                        $('.progress[data-mod="'+data.files[0].size+'"] .bar').css('width', '100%').addClass('red').html('');
                    },
                    done: function (event, data) {
                        window.onbeforeunload = null;

                        // Upload Complete, show information about the upload in a textarea
                        // from here you can do what you want as the file is on S3
                        // e.g. save reference to your server using another ajax call or log it, etc.
                        var original = data.files[0];
                        var s3Result = data.result.documentElement.children;
                        filesUploaded.push({
                            "original_name": original.name,
                            "s3_name": s3Result[2].innerHTML,
                            "size": original.size,
                            "url": s3Result[0].innerHTML
                        });
                        $('#uploaded').html(JSON.stringify(filesUploaded, null, 2));
                    }
                });
            });
        </script>
        
</body>
</html>
