<?php

namespace Jlisher\Languages\Contracts;

/**
 * Contract for the Language class
 *
 * @property-read string $name
 * @property-read string $native_name
 * @property-read string $alpha_2
 * @property-read string $alpha_3
 */
interface LanguageContract {
    /**
     * LanguageContract constructor.
     *
     * @param array $data
     */
    public function __construct($data);

    /**
     * Static way to instantiate the class.
     *
     * @param array $data
     *
     * @return \Jlisher\Languages\Contracts\LanguageContract
     */
    public static function instance($data);

    /**
     * Alias of LanguageContract::instance()
     *
     * @param array $data
     *
     * @return \Jlisher\Languages\Contracts\LanguageContract
     */
    public static function make($data);

    /**
     * __get is used to get the values from the $data property.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name);
}