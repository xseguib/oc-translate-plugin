<?php

namespace Weglot\TranslatePlugin;

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
}