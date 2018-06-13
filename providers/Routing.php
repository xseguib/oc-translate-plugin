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
use Weglot\Translate\Models\Settings;

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
                $settings = Settings::instance();

                // url instance :)
                $fullUrl = Server::fullUrl($_SERVER);
                $urlInstance = new Url(
                    $fullUrl,
                    $settings->original_language,
                    $settings->destination_languages
                );

                if ($urlInstance->getDefault() !== $urlInstance->detectCurrentLanguage() &&
                    $urlInstance->isTranslable()) {
                    $client = new Client($settings->api_key);

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