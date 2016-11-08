<?php

namespace App\Viender\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'        => (int) $user->id,
            'login'     => $user->username, 
            'name'      => $user->name, 
            'email'     => $user->email,
            'gender'    => $user->gender,
            'links'     => [
                [
                    'rel' => 'self',
                    'uri' => url('/users') . '/' . $user->id,
                ]
            ],
        ];
    }
}