<?php

namespace Weglot\TranslatePlugin;

use App;
use Config;
use System\Classes\PluginBase;
use Weglot\TranslatePlugin\Providers\Routing;

/**
 * Class Plugin.
 */
class Plugin extends PluginBase
{
    /**
     * {@inheritdoc}
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Weglot Translate Plugin',
            'description' => 'Translate your October CMS website easily.',
            'author'      => 'Baptiste Leduc',
            'icon'        => 'icon-language',
            'homepage'    => 'https://github.com/weglot/october-translate-plugin'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        App::register(Routing::class);
    }

    /**
     * {@inheritdoc}
     */
    public function registerComponents()
    {
        return [
            LanguageSelector::class => 'WeglotLanguages'
        ];
    }

}
