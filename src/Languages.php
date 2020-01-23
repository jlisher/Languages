<?php


namespace Jlisher\Languages;

/**
 * Languages is a class for getting Languages by ISO 639 codes and ISO 639 codes
 * by Language names.
 *
 * @author Jarryd Lisher
 * @version 1.0.0
 * @license MIT
 */
class Languages
{
    /**
     * Array of languages and codes.
     *
     * @var array
     */
    private $languages;

    /**
     * Loaded translations.
     *
     * @var array
     */
    private $translations;

    /**
     * Loaded fallback translations.
     */
    private $fallback_translations;

    /**
     * ISO 639-1 language code to display names in.
     *
     * @var string
     */
    private $locale;

    /**
     * ISO 639-1 language code to fallback to if translation doesn't exist.
     *
     * @var string
     */
    private $fallback_locale;

    /**
     * Languages constructor.
     *
     * @param string $locale
     * @param string $fallback_locale
     */
    public function __construct($locale = 'en', $fallback_locale = 'en')
    {
        $this->languages = require __DIR__ . '/resources/languages.php';

        $this->setLocale($locale);
        $this->setFallbackLocale($fallback_locale);
    }

    /**
     * Get the current locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set the current locale.
     *
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        $this->translations = include __DIR__ . '/i18n/' . $this->getLocale() . '.php';
    }

    /**
     * Get the fallback locale.
     *
     * @return string
     */
    public function getFallbackLocale()
    {
        return $this->fallback_locale;
    }

    /**
     * Set the fallback locale.
     *
     * @param string $fallback_locale
     */
    public function setFallbackLocale($fallback_locale)
    {
        $this->fallback_locale = $fallback_locale;

        $this->fallback_translations = include __DIR__ . '/i18n/' . $this->getFallbackLocale() . '.php';
    }

    /**
     * Get Language by ISO 639-1 alpha 2 code.
     *
     * @param string $code
     *
     * @return \Jlisher\Languages\Contracts\LanguageContract|\Jlisher\Languages\Language|bool
     */
    public function byAlpha2($code)
    {
        $language = $this->getLanguageByKey('alpha_2', $code);

        if (! $language) {
            return false;
        }

        $language['name'] = $this->getTranslation($language['alpha_2']);

        return Language::make($language);
    }

    /**
     * Get Language by ISO 639-2 alpha 3 code.
     *
     * @param string $code
     *
     * @return \Jlisher\Languages\Contracts\LanguageContract|\Jlisher\Languages\Language|bool
     */
    public function byAlpha3($code)
    {
        $language = $this->getLanguageByKey('alpha_3', $code);

        if (! $language) {
            return false;
        }

        $language['name'] = $this->getTranslation($language['alpha_2']);

        return Language::make($language);
    }

    /**
     * Get Language by native name.
     *
     * @param string $name
     *
     * @return bool|\Jlisher\Languages\Contracts\LanguageContract|\Jlisher\Languages\Language
     */
    public function byNativeName($name)
    {
        $language = $this->getLanguageByKey('native_name', $name);

        if (! $language) {
            return false;
        }

        $language['name'] = $this->getTranslation($language['alpha_2']);

        return Language::make($language);
    }

    /**
     * Get Language by translated name.
     *
     * @param string $name
     *
     * @return bool|\Jlisher\Languages\Contracts\LanguageContract|\Jlisher\Languages\Language
     */
    public function byName($name)
    {
        $translation = array_filter($this->translations, function ($value) use ($name) {
            return strtolower($value) === strtolower($name);
        });

        if (! $translation) {
            $translation = array_filter($this->fallback_translations, function ($value) use ($name) {
                return strtolower($value) === strtolower($name);
            });
        }

        if (! $translation) {
            return false;
        }

        $code = array_keys($translation);
        $code = array_shift($code);

        return $this->byAlpha2($code);
    }

    /**
     * Get language by given key.
     *
     * @param string $key
     * @param string $value
     *
     * @return array|bool
     */
    protected function getLanguageByKey($key, $value)
    {
        $language = array_filter($this->languages, function ($item) use ($key, $value) {
            return $item[$key] === $value;
        });

        $language = array_shift($language);

        if (! $language) {
            return false;
        }

        return $language;
    }

    /**
     * Get translated language name.
     *
     * @param string $code
     *
     * @return string|false - Returns FALSE on failure to retrieve translation.
     */
    protected function getTranslation($code)
    {
        if (! empty($this->translations[$code])) {
            return $this->translations[$code];
        }

        if (! empty($this->fallback_translations[$code])) {
            return $this->fallback_translations[$code];
        }

        return false;
    }
}
