<?php

namespace hollisho\htranslator\Locale;

use hollisho\objectbuilder\Exceptions\BuilderException;

/**
 * @author Hollis
 * @desc 本地化管理器
 * Class LocaleManager
 * @package hollisho\htranslator\Locale
 * @property $timezone
 * @property $default_locale
 * @property $locale
 * @property $enable_locale
 * @property $auto_detect
 * @property $auto_detect_var
 */
class LocaleManager implements LocaleAwareInterface
{
    /**
     * @var LocaleConfigVo
     */
    protected $config;

    /**
     * @param LocaleConfigVo|null $config
     * @throws BuilderException
     */
    public function __construct(?LocaleConfigVo $config = null)
    {
        if ($config === null) {
            $config = LocaleConfigVo::build();
        }

        $this->config = $config;
    }

    /**
     * @param string $locale
     * @return void
     */
    public function setLocale(string $locale): void
    {
        $this->config->setAttribute('locale', $locale);
    }

    public function getLocale(): string
    {
        return $this->config->getAttribute('locale') ?: $this->getDefaultLocale();
    }

    public function getDefaultLocale(): string
    {
        return $this->config->getAttribute('default_locale');
    }

    /**
     * @return void
     * @desc 重置默认语言
     */
    public function reset(): void
    {
        $this->setLocale($this->getDefaultLocale());
    }

    /**
     * @param string $attribute
     * @param $value
     * @return void
     * @desc 设置属性
     */
    public function __set(string $attribute, $value)
    {
        $this->config->setAttribute($attribute, $value);
    }

    /**
     * @param string $attribute
     * @return mixed|null
     * @desc 获取属性
     */
    public function __get(string $attribute)
    {
        return $this->config->getAttribute($attribute);
    }

}