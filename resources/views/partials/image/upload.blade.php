

        <div class="container">
            <h1>Direct Upload</h1>

            <!-- Direct Upload to S3 Form -->
            <form action="{{$s3FormDetails['url']}}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="direct-upload">

                @foreach ($s3FormDetails['inputs'] as $name => $value)
                  <input type="hidden" name="{{$name}}" value="{{$value}}">
                @endforeach

                <!-- Key is the file's name on S3 and will be filled in with JS -->
                <input type="hidden" name="key" value="">
                <input type="file" name="file" multiple>

                <!-- Progress Bars to show upload completion percentage -->
                <div class="progress-bar-area"></div>

            </form>

            <!-- This area will be filled with our results (mainly for debugging) -->
            <div>
                <h3>Files</h3>
                <textarea id="uploaded"></textarea>
            </div>

        </div>
