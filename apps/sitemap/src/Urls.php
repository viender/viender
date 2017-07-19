<?php

namespace Viender\Sitemap;

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
            $this->router->get('/sitemap', 'SitemapController@index')->name('viender.sitemap.sitemap.index');

            $this->router->get('/sitemap-answers.xml.gz', 'SitemapController@answersXml')->name('viender.sitemap.answers.index');

            $this->router->get('/sitemap-questions.xml.gz', 'SitemapController@questionsXml')->name('viender.sitemap.questions.index');

            $this->router->get('/sitemap-topics.xml.gz', 'SitemapController@topicsXml')->name('viender.sitemap.topics.index');

            $this->router->get('/sitemap-people.xml.gz', 'SitemapController@peopleXml')->name('viender.sitemap.people.index');

            $this->router->get('/sitemap.xml.gz', 'SitemapController@indexXml')->name('viender.sitemap.sitemap.indexXml');
        });
    }

    public function api()
    {
        $this->version1(['showVersionPrefix' => false]);
    }

    public function version1($option = [])
    {
        $namePrefix = 'api' . (isset($option['showVersionPrefix']) ? ($option['showVersionPrefix'] ? '.v1' : '') : '.v1') . '.viender.sitemap';

        $this->router->group(array_merge($option, ['domain' => config('viender.api_domain'), 'namespace' => 'Api', 'middleware' => 'api']), function() use ($namePrefix) {

        });
    }
}
