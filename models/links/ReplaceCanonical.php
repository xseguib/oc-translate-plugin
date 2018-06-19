<?php

namespace Weglot\TranslatePlugin\Models\Links;

class ReplaceCanonical extends AbstractReplace
{
    /**
     * {@inheritdoc}
     */
    const REGEX = '/<link rel="canonical"(.*?)?href=(\"|\')([^\s\>]+?)(\"|\')/';

    /**
     * {@inheritdoc}
     */
    protected function replace(ReplaceMatch $match, $translatedUrl)
    {
        $this->contents = preg_replace(
            '/<link rel="canonical"'.preg_quote($match->getBeforeTag(), '/').'href='.preg_quote($match->getBeforeQuote().$match->getUrl().$match->getAfterQuote(), '/' ).'/',
            '<link rel="canonical"'.$match->getBeforeTag().'href='.$match->getBeforeQuote().$translatedUrl.$match->getAfterQuote(),
            $this->contents);
    }
}