<?php namespace Weglot\TranslatePlugin\FormWidgets;

use Backend\Classes\FormWidgetBase;

class MultipleRows extends FormWidgetBase
{
    /**
     * {@inheritDoc}
     */
    protected $defaultAlias = 'multiplerows';

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->vars['fieldName'] = $this->formField->fieldName;

        return $this->makePartial('multiplerows');
    }

    /**
     * {@inheritDoc}
     */
    protected function loadAssets()
    {
        $this->addCss('css/multiplerows.css');
    }
}