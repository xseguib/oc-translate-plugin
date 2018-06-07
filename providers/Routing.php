<?php namespace Weglot\Translate\Providers;

use Cms\Classes\Controller;
use Cms\Classes\Router;
use Event;
use Illuminate\Support\ServiceProvider;
use Weglot\Client\Client;
use Weglot\Parser\ConfigProvider\ServerConfigProvider;
use Weglot\Parser\Parser;
use Weglot\Util\Url;
use Weglot\Util\Server;

/**
 * Class Routing.
 */
class Routing extends ServiceProvider
{
    /**
     * @var Controller
     */
    protected $controller;

    /**
     * @var bool
     */
    protected $active = false;

    public function boot()
    {
        // init Controller
        $this->controller = new Controller();

        // listen to routing events
        Event::listen('cms.router.beforeRoute', function($url, Router $router) {
            if(!$this->active) {
                $this->active = true;

                // url instance :)
                $fullUrl = Server::fullUrl($_SERVER);
                $urlInstance = new Url(
                    $fullUrl,
                    config('weglot-translate.original_language'),
                    config('weglot-translate.destination_languages')
                );

                if ($urlInstance->getDefault() !== $urlInstance->detectCurrentLanguage() &&
                    $urlInstance->isTranslable()) {
                    $client = new Client('wg_74d8b29411450e974c6d250cde53cf7a');

                    $config = new ServerConfigProvider();
                    $parser = new Parser($client, $config);

                    // get all the contents & translate it !
                    $content = $this->controller->run($urlInstance->getPath())->content();
                    $translated = $parser->translate(
                        $content,
                        $urlInstance->getDefault(),
                        $urlInstance->detectCurrentLanguage()
                    );

                    echo $translated;
                    exit;
                }
            }
            return null;
        });
    }
}