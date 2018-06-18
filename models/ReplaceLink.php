<?php

namespace Weglot\Translate\Models;

use Weglot\Util\Url;
use Weglot\Translate\Models\Url as UrlService;

class ReplaceLink
{
    /**
     * @param string $contents
     * @param Url $urlInstance
     * @return string
     */
    public static function make($contents, $urlInstance) {
        $contents = UrlService::modifyLink('/<a([^\>]+?)?href=(\"|\')([^\s\>]+?)(\"|\')([^\>]+?)?>/', 'a', $urlInstance, $contents);
        $contents = UrlService::modifyLink('/<form([^\>]+?)?action=(\"|\')([^\s\>]+?)(\"|\')/', 'form', $urlInstance, $contents);
        $contents = UrlService::modifyLink('/<link rel="canonical"(.*?)?href=(\"|\')([^\s\>]+?)(\"|\')/', 'canonical', $urlInstance, $contents);
        $contents = UrlService::modifyLink('/<meta property="og:url"(.*?)?content=(\"|\')([^\s\>]+?)(\"|\')/', 'meta', $urlInstance, $contents);
        return $contents;
    }

    /**
     * Replace href in <a>
     *
     * @param string $contents
     * @param string $url
     * @param Url $toolkit
     * @param string $beforeQuote
     * @param string $afterQuote
     * @param string $beforeTag
     * @param string $afterTag
     * @return string
     */
    public static function replaceA($contents, $url, Url $toolkit, $beforeQuote, $afterQuote, $beforeTag = null, $afterTag = null) {
        $currentLanguage = $toolkit->detectCurrentLanguage();
        $currentToolkit = new Url(
            $url,
            $toolkit->getDefault(),
            [$currentLanguage]
        );

        return preg_replace(
            '/<a'.preg_quote($beforeTag, '/').'href='.preg_quote($beforeQuote.$url.$afterQuote, '/').'/',
            '<a'.$beforeTag.'href='.$beforeQuote.$currentToolkit->getForLanguage($currentLanguage).$afterQuote,
            $contents);
    }

    /**
     * Replace form action attribute
     *
     * @param string $contents
     * @param string $url
     * @param Url $toolkit
     * @param string $beforeQuote
     * @param string $afterQuote
     * @param string $beforeTag
     * @param string $afterTag
     * @return string
     */
    public function replaceForm($contents, $url, Url $toolkit, $beforeQuote, $afterQuote, $beforeTag = null, $afterTag = null) {
        $currentLanguage = $toolkit->detectCurrentLanguage();
        $currentToolkit = new Url(
            $url,
            $toolkit->getDefault(),
            [$currentLanguage]
        );

        return preg_replace(
            '/<form'.preg_quote($beforeTag, '/').'action='.preg_quote($beforeQuote.$url.$afterQuote, '/' ).'/',
            '<form '.$beforeTag.'action='.$beforeQuote.$currentToolkit->getForLanguage($currentLanguage).$afterQuote,
            $contents);
    }

    /**
     * Replace canonical attribute
     *
     * @param string $contents
     * @param string $url
     * @param Url $toolkit
     * @param string $beforeQuote
     * @param string $afterQuote
     * @param string $beforeTag
     * @param string $afterTag
     * @return string
     */
    public function replaceCanonical($contents, $url, Url $toolkit, $beforeQuote, $afterQuote, $beforeTag = null, $afterTag = null) {
        $currentLanguage = $toolkit->detectCurrentLanguage();
        $currentToolkit = new Url(
            $url,
            $toolkit->getDefault(),
            [$currentLanguage]
        );

        return preg_replace(
            '/<link rel="canonical"'.preg_quote($beforeTag, '/').'href='.preg_quote($beforeQuote.$url.$afterQuote, '/' ).'/',
            '<link rel="canonical"'.$beforeTag.'href='.$beforeQuote.$currentToolkit->getForLanguage($currentLanguage).$afterQuote,
            $contents);
    }

    /**
     * Replace meta og url attribute
     *
     * @param string $contents
     * @param string $url
     * @param Url $toolkit
     * @param string $beforeQuote
     * @param string $afterQuote
     * @param string $beforeTag
     * @param string $afterTag
     * @return string
     */
    public function replaceMeta($contents, $url, Url $toolkit, $beforeQuote, $afterQuote, $beforeTag = null, $afterTag = null) {
        $currentLanguage = $toolkit->detectCurrentLanguage();
        $currentToolkit = new Url(
            $url,
            $toolkit->getDefault(),
            [$currentLanguage]
        );

        return preg_replace(
            '/<meta property="og:url"'.preg_quote($beforeTag, '/').'content='.preg_quote($beforeQuote.$url.$afterQuote, '/' ).'/',
            '<meta property="og:url"'.$beforeTag.'content='.$beforeQuote.$currentToolkit->getForLanguage($currentLanguage).$afterQuote,
            $contents);
    }
}