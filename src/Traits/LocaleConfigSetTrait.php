<?php

namespace hollisho\htranslator\Traits;

use hollisho\htranslator\Locale\LocaleConfig;
use hollisho\objectbuilder\Exceptions\UnknownPropertyException;

/**
 * @author Hollis
 * @desc
 * Trait LocaleConfigSetTrait
 * @package hollisho\htranslator\Traits
 */
trait LocaleConfigSetTrait
{
    /**
     * @var LocaleConfig
     */
    private $config;

    /**
     * @desc 设置Config指定属性值
     * @param $attribute
     * @param $value
     * @return void
     * @throws UnknownPropertyException
     */
    private function setConfigAttribute($attribute, $value) {
        if (!property_exists($this, 'config')) {
            throw new UnknownPropertyException('unknown property: config');
        }

        $this->config->setAttribute($attribute, $value);
    }

    /**
     * @param $locale
     * @return void
     * @throws UnknownPropertyException
     */
    public function setDefaultLocale($locale)
    {
        $this->setConfigAttribute('default_locale', $locale);
    }

    /**
     *
     * @desc
     * @param $allow_group
     * @return void
     * @throws UnknownPropertyException
     */
    public function setAllowGroup($allow_group)
    {
        $this->setConfigAttribute('allow_group', $allow_group);
    }

    /**
     * @param $enable_locale
     * @return void
     * @throws UnknownPropertyException
     */
    public function setEnableLocale($enable_locale)
    {
        $this->setConfigAttribute('enable_locale', $enable_locale);
    }

    /**
     * @param bool $locale_path
     * @return void
     * @throws UnknownPropertyException
     */
    public function setLocalePath(bool $locale_path)
    {
        $this->setConfigAttribute('locale_path', $locale_path);
    }
}