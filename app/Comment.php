<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $table = "comments";

    protected $fillable = ['name', 'email', 'comment', 'approved' ,'post_id', 'created_at', 'updated_at'];
    
    // --------------------------------------------------------------
     /**
     * Get the post that belongs to this comment
     * One Comment Belongs To One Post
     */
    public function post(){
         return $this->belongsTo('App\Post');
    }
}
