<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";

    protected $fillable = ["text","parent_id","user_id","image_id"];

    public function children()
    {
        return $this->hasMany(Comment::class,"parent_id","id");
    }
    public function parent()
    {
        return $this->belongsTo(Comment::class,"parent_id");
    }
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
