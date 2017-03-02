<?php

namespace Viender\Socialite\Models;

use Viender\Socialite\Traits\HasVotes;
use Viender\Socialite\Traits\HasComments;
use Illuminate\Database\Eloquent\Model;
use Viender\Socialite\Contracts\Post\Upvotable;
use Viender\Socialite\Contracts\Post\Commentable;

class Comment extends Model implements Upvotable, Commentable
{
    use HasComments, HasVotes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'commentable_id', 'commentable_type', 'body',
    ];

    public function user() 
    {
        return $this->belongsTo('App\User');
    }

    public function commentable() 
    {
        return $this->morphTo();
    }
}
