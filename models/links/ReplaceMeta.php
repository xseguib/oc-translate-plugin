<?php

namespace Weglot\Translate\Models\Links;

class ReplaceMeta extends AbstractReplace
{
    /**
     * {@inheritdoc}
     */
    const REGEX = '/<meta property="og:url"(.*?)?content=(\"|\')([^\s\>]+?)(\"|\')/';

    /**
     * {@inheritdoc}
     */
    protected function replace(ReplaceMatch $match, $translatedUrl)
    {
        $this->contents = preg_replace(
            '/<meta property="og:url"'.preg_quote($match->getBeforeTag(), '/').'content='.preg_quote($match->getBeforeQuote().$match->getUrl().$match->getAfterQuote(), '/' ).'/',
            '<meta property="og:url"'.$match->getBeforeTag().'content='.$match->getBeforeQuote().$translatedUrl.$match->getAfterQuote(),
            $this->contents);
    }
}