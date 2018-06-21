<?php

namespace Weglot\TranslatePlugin\Providers;

use Cms\Classes\Controller;
use Cms\Classes\Router;
use Event;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Weglot\Client\Client;
use Weglot\Parser\ConfigProvider\ServerConfigProvider;
use Weglot\Parser\Parser;
use Weglot\TranslatePlugin\Models\ReplaceLinks;
use Weglot\Util\Url;
use Weglot\Util\Server;
use Weglot\TranslatePlugin\Models\Settings;
use Cache\Adapter\Illuminate\IlluminateCachePool;

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
                $urlInstance->setExcludedUrls($settings->excludeUrls);

                if ($urlInstance->getDefault() !== $urlInstance->detectCurrentLanguage() &&
                    $urlInstance->isTranslable()) {
                    $client = new Client($settings->api_key);

                    if($settings->cache) {
                        $cachePool = new IlluminateCachePool(Cache::getStore());
                        $client->setCacheItemPool($cachePool);
                    }

                    $config = new ServerConfigProvider();
                    $parser = new Parser($client, $config, $settings->excludeBlocks);

                    // get all the contents
                    $content = $this->controller->run($urlInstance->getPath())->content();
                    
                    // translate all our content !
                    $translated = $parser->translate(
                        $content,
                        $urlInstance->getDefault(),
                        $urlInstance->detectCurrentLanguage()
                    );

                    // replace links depending on current language
                    $replaceLinks = new ReplaceLinks($urlInstance, $translated);
                    $translated = $replaceLinks->handle();

                    echo $translated;
                    exit;
                }
            }
            return null;
        });
    }
}