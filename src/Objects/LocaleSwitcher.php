<?php

namespace hollisho\htranslator\Objects;

use hollisho\helpers\ArrayHelper;
use hollisho\helpers\InvalidArgumentException;
use hollisho\htranslator\Contracts\LocaleAwareInterface;
use hollisho\htranslator\Traits\LocaleConfigSetTrait;
use hollisho\objectbuilder\Exceptions\BuilderException;
use hollisho\objectbuilder\Exceptions\UnknownPropertyException;
use hollisho\objectbuilder\HObject;
use hollisho\objectbuilder\ObjectBuilder;

/**
 * @author Hollis Ho
 * Class LocaleSwitcher
 * @package hollisho\htranslator
 * @property $config LocaleConfig
 */
class LocaleSwitcher extends HObject implements LocaleAwareInterface
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
        /** @var LocaleConfig config */
        $this->config = ObjectBuilder::build(LocaleConfig::class, $config);
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
     * Switch to a new locale, execute a callback, then switch back to the original.
     * @param string $locale
     * @param callable(string $locale):T $callback
     * @return mixed
     * @throws UnknownPropertyException
     */
    public function runWithLocale(string $locale, callable $callback)
    {
        $original = $this->getLocale();
        $this->setLocale($locale);

        try {
            return $callback($locale);
        } finally {
            $this->setLocale($original);
        }
    }

    /**
     * @throws UnknownPropertyException
     */
    public function reset(): void
    {
        $this->setLocale($this->getDefaultLocale());
    }
}