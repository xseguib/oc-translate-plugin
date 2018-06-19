<?php namespace Weglot\Translate\FormWidgets;

use Request;
use Backend\Classes\FormWidgetBase;
use Weglot\Client\Factory\Languages;

class OriginalLanguage extends FormWidgetBase
{
    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'originallanguage';

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->vars['languages'] = $this->getLanguagesData();
        $this->vars['data'] = $this->getLanguagesData(true);
        $this->vars['selector'] = $this->getLoadValue();

        return $this->makePartial('originallanguage');
    }

    /**
     * {@inheritDoc}
     */
    protected function loadAssets()
    {
        $this->addCss('css/selectize.css');
        $this->addJs('js/selectize.js');
    }

    /**
     * {@inheritDoc}
     */
    public function getSaveValue($value)
    {
        return post('original_language');
    }

    /**
     * @param bool $withKeys
     * @return string
     */
    private function getLanguagesData($withKeys = false)
    {
        $languages = Languages::data();
        if(!$withKeys) {
            $languages = array_values($languages);
        }
        return json_encode($languages);
    }
}