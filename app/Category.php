<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";


    /**
     * Get the posts for one category
     * One Category Has Many Posts
     */
    public function posts(){
        return $this->hasMany('App\Post');
    }
}
