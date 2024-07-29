<?php

namespace hollisho\htranslator\Locale;

use hollisho\helpers\ArrayHelper;
use hollisho\helpers\InvalidArgumentException;
use hollisho\htranslator\Traits\LocaleConfigSetTrait;
use hollisho\objectbuilder\Exceptions\BuilderException;
use hollisho\objectbuilder\Exceptions\UnknownPropertyException;

/**
 * @author Hollis Ho
 * Class LocaleSwitcher
 * @package hollisho\htranslator
 */
class LocaleManager implements LocaleAwareInterface
{
    use LocaleConfigSetTrait;

    /**
     * @param array $params
     * @throws BuilderException|UnknownPropertyException
     * @throws InvalidArgumentException
     */
    public function __construct(array $params = [])
    {
        $config = ArrayHelper::getValue($params, 'config', []);
        $locale = ArrayHelper::getValue($params, 'locale', '');
        /** @var LocaleConfig $localeConfig */
        $localeConfig = LocaleConfig::build($config);
        $this->config = $localeConfig;
        $this->setLocale($locale ?: $this->getDefaultLocale());
    }

    /**
     * @throws UnknownPropertyException
     */
    public function setLocale(string $locale): void
    {
        $this->setConfigAttribute('locale', $locale);
    }

    public function getLocale(): string
    {
        return $this->config->getAttribute('locale');
    }

    public function getDefaultLocale(): string
    {
        return $this->config->getAttribute('default_locale');
    }

    /**
     * @throws UnknownPropertyException
     */
    public function reset(): void
    {
        $this->setLocale($this->getDefaultLocale());
    }
}