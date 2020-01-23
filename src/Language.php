<?php

namespace Jlisher\Languages;

use Jlisher\Languages\Contracts\LanguageContract;

/**
 * language Class to get the information on a language.
 */
class Language implements LanguageContract {

    /**
     * Array of data for the language.
     *
     * @var array
     */
    protected $data;

    /**
     * @inheritDoc
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public static function instance($data)
    {
        return new static($data);
    }

    /**
     * @inheritDoc
     */
    public static function make($data)
    {
        return static::instance($data);
    }

    /**
     * @inheritDoc
     */
    public function __get($name)
    {
        if (! isset($this->data[$name])) {
            return null;
        }

        return $this->data[$name];
    }
}