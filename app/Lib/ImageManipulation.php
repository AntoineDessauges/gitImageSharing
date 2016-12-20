<?php
namespace App\Lib;
use Illuminate\Http\File;
use Storage;
class ImageManipulation
{
  public static $thumbnail_suffix = "_thumb";
  public static function thumbnailName($path)
  {
    return $path.self::$thumbnail_suffix;
  }
  public static function createThumbnail($path)
  {
    $final_path = static::thumbnailName($path);
    if(!Storage::exists(basename($final_path)))//don't create the thumbnail if it already exists
    {
        $f = new File($path);
        if($f->guessExtension() != "svg")//don't process svgs
        {
            $thumb = \Image::make($path);

            //$thumb->fit(200,200);
            $thumb->fit(200);

            $thumb->save($final_path);
        }
        else{//just copy svgs to the final dest path for thumbnails
            try{
                Storage::copy(basename($f->path()),basename($final_path));
            }catch(\Exception $e)
            {

            }

        }
    }
    return $final_path;
  }

}
