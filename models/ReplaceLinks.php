<?php

namespace Weglot\TranslatePlugin\Models;

use Weglot\TranslatePlugin\Models\Links\ReplaceA;
use Weglot\TranslatePlugin\Models\Links\ReplaceCanonical;
use Weglot\TranslatePlugin\Models\Links\ReplaceForm;
use Weglot\TranslatePlugin\Models\Links\ReplaceMeta;
use Weglot\Util\Url;

class ReplaceLinks
{
    /**
     * @var Url
     */
    protected $currentUrlToolkit;

    /**
     * @var string
     */
    protected $contents;

    /**
     * Providers we gonna use to replace links
     *
     * @var array
     */
    protected $providers = [
        ReplaceA::class,
        ReplaceForm::class,
        ReplaceMeta::class,
        ReplaceCanonical::class
    ];

    /**
     * ReplaceLinks constructor.
     * @param Url $currentUrlToolkit
     * @param string $contents
     */
    public function __construct(Url $currentUrlToolkit, $contents)
    {
        $this->currentUrlToolkit = $currentUrlToolkit;
        $this->contents = $contents;
    }

    /**
     * Replace links based on given providers
     *
     * @return string
     */
    public function handle()
    {
        foreach ($this->providers as $provider) {
            $instance = new $provider($this->contents, $this->currentUrlToolkit);
            $this->contents = $instance->handle();
        }

        return $this->contents;
    }
}