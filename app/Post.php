<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $table = "posts";

    protected $fillable = ['title', 'body', 'created_at', 'updated_at'];

    //-------------------------
    /**
     * Get the comments for the blog post.
     * One Post Has Many Comments
     */
    public function comments(){
        return $this->hasMany('App\Comment');
   }

   /**
     * Get the category of the post.
     * One Post Belongs To One Category
     */
    public function category(){
        return $this->belongsTo('App\Category');
   }
}
