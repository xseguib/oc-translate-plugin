<?php

namespace Weglot\Translate\Models;

use Weglot\Util\Url as UrlUtil;

class Url
{
    /**
     * Replace link
     *
     * @param string $regex
     * @param string $type
     * @param UrlUtil $toolkit
     * @param string $contents
     * @return string
     */
    public static function modifyLink($regex, $type, UrlUtil $toolkit, $contents) {
        $matches = [];
        $count = preg_match_all($regex , $contents, $matches);

        for ($i = 0; $i < $count; ++$i) {
            list(
                $beforeTag,
                $beforeQuote,
                $url,
                $afterQuote,
                $afterTag,
            ) = [
                (isset($matches[1]) && isset($matches[1][$i])) ? $matches[1][$i] : null,
                (isset($matches[2]) && isset($matches[2][$i])) ? $matches[2][$i] : null,
                (isset($matches[3]) && isset($matches[3][$i])) ? $matches[3][$i] : null,
                (isset($matches[4]) && isset($matches[4][$i])) ? $matches[4][$i] : null,
                (isset($matches[5]) && isset($matches[5][$i])) ? $matches[5][$i] : null
            ];

            if (self::checkLink($url, $toolkit, $beforeTag, $afterTag)) {
                $funcName = 'replace'.ucfirst($type);
                $contents = ReplaceLink::$funcName(
                    $contents,
                    $url,
                    $toolkit,
                    $beforeQuote,
                    $afterQuote,
                    $beforeTag,
                    $afterTag
                );
            }
        }
        return $contents;
    }

    /**
     * Checks if link is valid
     *
     * @param string $url
     * @param UrlUtil $toolkit
     * @param string $beforeTag
     * @param string $afterTag
     * @return bool
     */
    public static function checkLink($url, UrlUtil $toolkit, $beforeTag = null, $afterTag = null) {
        $parsed_url  = parse_url($url);

        return (
            (
                ($url[0] === 'h' && $parsed_url['host'] === $_SERVER['HTTP_HOST'] ) ||
                (isset($url[0]) && $url[0] === '/' && (isset($url[1])) && '/' !== $url[1])
            )
            && !self::isFileLink($url)
            && $toolkit->isTranslable()
            && strpos($beforeTag, 'data-wg-notranslate') === false
            && strpos($afterTag, 'data-wg-notranslate') === false
        );
    }

    /**
     * Checks if given url is a file
     *
     * @param string $url
     * @return boolean
     */
    public static function isFileLink($url) {
        $types = [
            'pdf',
            'rar',
            'doc',
            'docx',
            'jpg',
            'jpeg',
            'png',
            'ppt',
            'pptx',
            'xls',
            'zip',
            'mp4',
            'xlsx',
        ];

        foreach ($types as $type) {
            if (self::stringEndsWith($url, '.'.$type)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Search forward starting from end minus needle length characters
     *
     * @param string $haystack
     * @param string $needle
     * @return boolean
     */
    public static function stringEndsWith( $haystack, $needle ) {
        $temp = strlen( $haystack );
        return '' === $needle ||
            (
                (  $temp - strlen( $needle ) ) >= 0 && strpos( $haystack, $needle, $temp ) !== false
            );
    }
}