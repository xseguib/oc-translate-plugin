<?php

namespace Weglot\TranslatePlugin\Models\Links;

use Weglot\Util\Url;

abstract class AbstractReplace
{
    /**
     * Contains the used regex to match the current case
     *
     * @var string
     */
    const REGEX = '';

    /**
     * @var string
     */
    protected $contents;

    /**
     * @var Url
     */
    protected $url;

    /**
     * AbstractReplace constructor.
     * @param string $contents
     * @param Url $url
     */
    public function __construct($contents, Url $url)
    {
        $this->contents = $contents;
        $this->url = $url;
    }

    /**
     * Try to match depending on REGEX and replace contents
     *
     * @throws \Exception
     */
    public function handle()
    {
        $called = \get_called_class();

        // check if REGEX has been filled
        if($called::REGEX === '') {
            throw new \Exception('Regex pattern is empty');
        }

        $matches = [];
        $count = preg_match_all($called::REGEX , $this->contents, $matches);

        for ($i = 0; $i < $count; ++$i) {
            $match = new ReplaceMatch($matches, $i);
            $matchUrl = $this->getMatchUrlInstance($match);

            if ($this->checkLink($match)) {
                $this->replace($match, $matchUrl->getForLanguage($this->url->detectCurrentLanguage()));
            }
        }
        return $this->contents;
    }

    /**
     * Make the replace process
     *
     * @param ReplaceMatch $match
     * @param string $translatedUrl
     * @return string
     */
    abstract protected function replace(ReplaceMatch $match, $translatedUrl);

    /**
     * Check if matched url is valid
     *
     * @param ReplaceMatch $match
     * @return bool
     */
    protected function checkLink(ReplaceMatch $match)
    {
        $url = $match->getUrl();
        $parsed_url  = parse_url($url);

        return (
            (
                ($url[0] === 'h' && $parsed_url['host'] === $_SERVER['HTTP_HOST'] ) ||
                (isset($url[0]) && $url[0] === '/' && (isset($url[1])) && '/' !== $url[1])
            )
            && !$this->isFileLink($url)
            && $this->url->isTranslable()
            && strpos($match->getBeforeTag(), 'data-wg-notranslate') === false
            && strpos($match->getAfterTag(), 'data-wg-notranslate') === false
        );
    }

    /**
     * Checks if given url is a file
     *
     * @param string $url
     * @return boolean
     */
    protected function isFileLink($url)
    {
        $types = [
            'pdf', 'rar', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'ppt',
            'pptx', 'xls', 'zip', 'mp4', 'xlsx',
        ];

        foreach ($types as $type) {
            if ($this->stringEndsWith($url, '.'.$type)) {
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
    protected function stringEndsWith( $haystack, $needle ) {
        $temp = strlen( $haystack );
        return '' === $needle ||
            (
                (  $temp - strlen( $needle ) ) >= 0 && strpos( $haystack, $needle, $temp ) !== false
            );
    }

    /**
     * @param ReplaceMatch $match
     * @return Url
     */
    protected function getMatchUrlInstance(ReplaceMatch $match)
    {
        return new Url(
            $match->getUrl(),
            $this->url->getDefault(),
            [$this->url->detectCurrentLanguage()]
        );
    }
}