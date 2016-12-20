<?php

namespace App\Listeners;

use App\Events\FileWasUploaded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\CreateThumbnail;
use App\Jobs\UploadToCloud;
class UploadFile implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FileWasUploaded  $event
     * @return void
     */
    public function handle(FileWasUploaded $event)
    {
        return true;
    }
}
