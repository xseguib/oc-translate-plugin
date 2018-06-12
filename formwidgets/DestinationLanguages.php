<?php namespace Weglot\Translate\FormWidgets;

use Request;
use Backend\Classes\FormWidgetBase;
use Weglot\Client\Factory\Languages;

class DestinationLanguages extends FormWidgetBase
{
    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'destinationlanguages';

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->vars['languages'] = $this->getDestinationLanguagesData();
        $this->vars['selector'] = $this->getLoadValue();

        return $this->makePartial('destinationlanguages');
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
        return post('destination_languages');
    }

    /**
     * @return array
     */
    private function getDestinationLanguagesData()
    {
        return json_encode(array_values(Languages::data()));
    }
}