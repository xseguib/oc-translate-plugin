<?php

namespace Weglot\Translate\Models\Links;

class ReplaceA extends AbstractReplace
{
    /**
     * {@inheritdoc}
     */
    const REGEX = '/<a([^\>]+?)?href=(\"|\')([^\s\>]+?)(\"|\')([^\>]+?)?>/';

    /**
     * {@inheritdoc}
     */
    protected function replace(ReplaceMatch $match, $translatedUrl)
    {
        $this->contents = preg_replace(
            '/<a'.preg_quote($match->getBeforeTag(), '/').'href='.preg_quote($match->getBeforeQuote().$match->getUrl().$match->getAfterQuote(), '/').'/',
            '<a'.$match->getBeforeTag().'href='.$match->getBeforeQuote().$translatedUrl.$match->getAfterQuote(),
            $this->contents);
    }
}