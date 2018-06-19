<?php

namespace Weglot\Translate\Models\Links;

class ReplaceForm extends AbstractReplace
{
    /**
     * {@inheritdoc}
     */
    const REGEX = '/<form([^\>]+?)?action=(\"|\')([^\s\>]+?)(\"|\')/';

    /**
     * {@inheritdoc}
     */
    protected function replace(ReplaceMatch $match, $translatedUrl)
    {
        $this->contents = preg_replace(
            '/<form'.preg_quote($match->getBeforeTag(), '/').'action='.preg_quote($match->getBeforeQuote().$match->getUrl().$match->getAfterQuote(), '/' ).'/',
            '<form '.$match->getBeforeTag().'action='.$match->getBeforeQuote().$translatedUrl.$match->getAfterQuote(),
            $this->contents);
    }
}