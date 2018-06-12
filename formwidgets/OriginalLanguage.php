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
     * @return array
     */
    private function getLanguagesData()
    {
        return json_encode(array_values(Languages::data()));
    }
}