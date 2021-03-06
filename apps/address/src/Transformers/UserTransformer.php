<?php

namespace Viender\Address\Transformers;

use App\User;
use Illuminate\Support\Facades\Storage;
use Viender\Address\Transformers\DatabaseNotificationTransformer;

class UserTransformer extends Transformer
{
    protected $availableIncludes = [];

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'                    => (int) $user->id,
            'type'                  => 'user',
            'login'                 => $user->username,
            'name'                  => $user->first_name . ' ' . $user->last_name,
            'first_name'            => $user->first_name,
            'last_name'             => $user->last_name,
            'email'                 => $user->email,
            'bio'                   => $user->bio,
            'location'              => $user->location,
            'website'               => $user->website,
            'gender'                => $user->gender,
            'tutorial_complete_at'  => $user->tutorial_complete_at,
            'answer_views'          => $user->answerViews(),
            'links'         => [
                [
                    'rel' => 'self',
                    'url' => url('/users') . '/' . $user->username,
                ],
                [
                    'rel' => 'self_html',
                    'url' => route('web.viender.profile.pages.profile', $user->username),
                ],
                [
                    'rel' => 'credentials',
                    'url' => route('api.viender.credential.users.credentials.index', $user),
                ],
                [
                    'rel' => 'avatar',
                    'url' => Storage::url($user->avatar_url),
                ],
                [
                    'rel' => 'avatar_medium',
                    'url' => Storage::url($user->avatar_medium_url),
                ],
                [
                    'rel' => 'avatar_large',
                    'url' => Storage::url($user->avatar_large_url),
                ],
            ],
        ];
    }

    /**
     * Include Question
     *
     * @return League\Fractal\ItemResource
     */
    public function includeNotifications($user)
    {
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();

        return $this->collection($notifications, new DatabaseNotificationTransformer(), 'notifications');
    }
}
