<?php

namespace App;

use App\Contracts\Post\Upvotable;
use App\Contracts\Post\Commentable;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model implements Upvotable, Commentable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'question_id', 'title', 'body',
    ];
    
    public function user() 
    {
        return $this->belongsTo('App\User');
    }

    public function question() 
    {
        return $this->belongsTo('App\Question');
    }

    public function comments() 
    {
        return $this->morphMany('App\Comment', 'commentable');
    }
    
    public function upvotes()
    {
        return $this->morphMany('App\Upvote', 'upvotable');
    }

    public function downvotes()
    {
        return $this->morphMany('App\Downvote', 'downvotable');
    }
}
