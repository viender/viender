<?php

namespace Viender\Follow;

use Illuminate\Contracts\Routing\Registrar as Router;

class Urls
{
    /**
     * The router implementation.
     *
     * @var Router
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  Router  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->web();
        $this->api();
    }

    public function web($option = [])
    {
        $this->router->group(array_merge($option, ['domain' => config('viender.web_domain'), 'middleware' => 'web']), function() {

        });
    }

    public function api()
    {
        $this->version1(['showVersionPrefix' => false]);
    }

    public function version1($option = [])
    {
        $namePrefix = 'api' . (isset($option['showVersionPrefix']) ? ($option['showVersionPrefix'] ? '.v1' : '') : '.v1') . '.viender.follow';

        $this->router->group(array_merge($option, ['domain' => config('viender.api_domain'), 'namespace' => 'Api', 'middleware' => 'api']), function() use ($namePrefix) {

            $this->router->get('users/{follower}/followers/{followee}/check', 'UserFollowingsController@check');

            $this->router->resource(
                'users.followers',
                'UserFollowersController',
                [
                    'as' => $namePrefix,
                    'only' => ['index']
                ]
            );

            $this->router->resource(
                'users.followings',
                'UserFollowingsController',
                [
                    'as' => $namePrefix,
                    'only' => ['index', 'store']
                ]
            );

            $this->router->delete(
                'users/{user1}/followings/{user2}',
                'UserFollowingsController@destroy'
            )->name($namePrefix . '.users.followings.destroy');

            $this->router->resource(
                'topics.followers',
                'TopicFollowersController',
                [
                    'as' => $namePrefix,
                    'only' => ['index']
                ]
            );
        });
    }
}
