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

        $values = $this->getLoadValue();
        if($values === null) {
            $values = [];
        }
        $this->vars['values'] = json_encode($values);

        return $this->makePartial('multiplerows');
    }

    /**
     * {@inheritDoc}
     */
    protected function loadAssets()
    {
        $this->addCss('css/multiplerows.css');
    }

    /**
     * {@inheritdoc}
     */
    public function getSaveValue($value)
    {
        $rows = post($this->formField->fieldName);

        // remove first row
        array_shift($rows);

        return $rows;
    }
}