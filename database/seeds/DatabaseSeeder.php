<?php

use App\Album;
use App\Image;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction(); //Start transaction!
        try{
            $user = User::create([
                "name"=>"thomas",
                "email"=>"thomas.ricci@cpnv.ch",
                "password"=>bcrypt("123456")
            ]);
            $album = $user->albums()->create(["name"=>"default"]);
            $user = User::create([
                "name"=>"este",
                "email"=>"westixy@gmail.com",
                "password"=>bcrypt("123456")
            ]);
            //$album = Album::create(["name"=>"default","user"=>$user]);
            $f = new \Illuminate\Http\File(storage_path("tests/img.bmp"));
            $image = Image::create(["filename"=>$f->getFilename(),"user_id"=>$user->id,"album_id"=>$album->id]);
            \File::copy($f->path(),$image->path);
            //$user->images()->create(["filename"=>$f->getFilename()]);
            // $this->call(UsersTableSeeder::class);
        }catch(\Exception $e){
            var_dump($e->getMessage());
            \DB::rollBack();
        }
        \DB::commit();

    }
}
