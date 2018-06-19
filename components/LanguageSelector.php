<?php

namespace Weglot\TranslatePlugin\Components;

use Cms\Classes\ComponentBase;

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
        return [
            [
                'code' => 'en',
                'local' => 'English',
                'url' => 'http://october.local/'
            ],
            [
                'code' => 'fr',
                'local' => 'Français',
                'url' => 'http://october.local/fr/'
            ]
        ];
    }
}