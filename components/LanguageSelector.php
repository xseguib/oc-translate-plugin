<?php

namespace Weglot\TranslatePlugin\Components;

use Cms\Classes\ComponentBase;
use Weglot\Client\Factory\Languages;
use Weglot\TranslatePlugin\Models\Settings;
use Weglot\Util\Server;
use Weglot\Util\Url;

class LanguageSelector extends ComponentBase
{
    /**
     * {@inheritdoc}
     */
    public function componentDetails()
    {
        return [
            'name' => 'Language Selector',
            'description' => 'Display a language selector based on Weglot settings.'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function defineProperties()
    {
        return [
            'template' => [
                'title'             => 'Template',
                'description'       => 'Template you wanna use for your language selector',
                'default'           => 'horizontal',
                'type'              => 'dropdown'
            ]
        ];
    }

    /**
     * Options for template parameter
     *
     * @return array
     */
    public function getTemplateOptions()
    {
        return [
            'horizontal' => 'Horizontal',
            'vertical' => 'Vertical'
        ];
    }

    /**
     * @return array
     */
    public function languages()
    {
        $settings = Settings::instance();
        $fullUrl = Server::fullUrl($_SERVER);
        $urlToolkit = new Url(
            $fullUrl,
            $settings->original_language,
            $settings->destination_languages
        );
        $languages = Languages::data();

        $data = [];
        foreach($urlToolkit->currentRequestAllUrls() as $code => $url) {
            $data[] = [
                'code' => $code,
                'local' => $languages[$code]['local'],
                'url' => $url
            ];
        }

        return $data;
    }
}