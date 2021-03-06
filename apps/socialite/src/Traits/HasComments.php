<?php

namespace Viender\Socialite\Traits;

trait HasComments
{
    public function comments() 
    {
        return $this->morphMany('Viender\Socialite\Models\Comment', 'commentable');
    }
}