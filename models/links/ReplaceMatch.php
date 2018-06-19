<?php

namespace Weglot\TranslatePlugin\Models\Links;

class ReplaceMatch
{
    /**
     * @var null|string
     */
    protected $beforeTag = null;

    /**
     * @var null|string
     */
    protected $afterTag = null;

    /**
     * @var null|string
     */
    protected $beforeQuote = null;

    /**
     * @var null|string
     */
    protected $afterQuote = null;

    /**
     * @var null|string
     */
    protected $url = null;

    /**
     * ReplaceMatch constructor.
     * @param array $matches
     * @param int $index
     */
    public function __construct(array $matches, $index)
    {
        $this->fill($matches, $index);
    }

    /**
     * Fill all member variables
     *
     * @param array $matches
     * @param $index
     */
    public function fill(array $matches, $index)
    {
        $this->beforeTag = (isset($matches[1]) && isset($matches[1][$index])) ? $matches[1][$index] : null;
        $this->beforeQuote = (isset($matches[2]) && isset($matches[2][$index])) ? $matches[2][$index] : null;
        $this->url = (isset($matches[3]) && isset($matches[3][$index])) ? $matches[3][$index] : null;
        $this->afterQuote = (isset($matches[4]) && isset($matches[4][$index])) ? $matches[4][$index] : null;
        $this->afterTag = (isset($matches[5]) && isset($matches[5][$index])) ? $matches[5][$index] : null;
    }

    /**
     * @return null|string
     */
    public function getBeforeTag()
    {
        return $this->beforeTag;
    }

    /**
     * @return null|string
     */
    public function getAfterTag()
    {
        return $this->afterTag;
    }

    /**
     * @return null|string
     */
    public function getBeforeQuote()
    {
        return $this->beforeQuote;
    }

    /**
     * @return null|string
     */
    public function getAfterQuote()
    {
        return $this->afterQuote;
    }

    /**
     * @return null|string
     */
    public function getUrl()
    {
        return $this->url;
    }
}