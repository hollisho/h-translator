<?php

namespace hollisho\htranslator;

use hollisho\htranslator\Locale\LocaleAwareInterface;
use hollisho\htranslator\Locale\LocaleManager;
use hollisho\htranslator\Locale\LocaleVo;
use Moment\Moment;
use Moment\CustomFormats\MomentJs;
use Moment\MomentException;

/**
 * @author Hollis
 * @desc 时间日期国际化
 * Class MomentTranslator
 * @package hollisho\htranslator
 */
class MomentTranslator implements LocaleAwareInterface
{

    /**
     * @var LocaleManager
     */
    private $locale_manager;

    /**
     * @var Moment
     */
    private $moment;

    private $date_time = 'now';

    private $immutable_mode = false;

    /**
     * @param LocaleManager|null $locale_manager
     * @throws MomentException
     */
    public function __construct(?LocaleManager $locale_manager = null)
    {
        if (null === $locale_manager) {
            $locale_manager = new LocaleManager();
        }

        $this->locale_manager = $locale_manager;
        $this->moment = new Moment();

        $this->setMomentLocale($this->locale_manager->getLocale());
    }

    /**
     * @throws MomentException
     */
    public function setLocale(string $locale): void
    {
        $this->locale_manager->setLocale($locale);
        $this->setMomentLocale($locale);
    }

    public function getLocale(): string
    {
        return $this->locale_manager->getLocale();
    }

    public function reset(): void
    {
        $this->locale_manager->reset();
    }

    /**
     * @throws MomentException
     */
    public function setMomentLocale($locale)
    {
        if (LocaleVo::assertValidLocale($locale)) {
            $this->moment::setLocale($locale);
        } else {
            $this->moment::setLocale( LocaleVo::ZH_CN);
        }
    }

    public function getMoment(): Moment
    {
        return $this->moment;
    }

    /**
     * @return string
     */
    public function getDateTime(): string
    {
        return $this->date_time;
    }

    /**
     * @param string $date_time
     * @throws MomentException
     */
    public function setDateTime(string $date_time): void
    {
        $this->date_time = $date_time;
        $this->moment->resetDateTime($date_time);
    }

    /**
     * @return bool
     */
    public function isImmutableMode(): bool
    {
        return $this->immutable_mode;
    }

    /**
     * @param bool $immutable_mode
     */
    public function setImmutableMode(bool $immutable_mode): void
    {
        $this->immutable_mode = $immutable_mode;
        $this->moment->setImmutableMode($immutable_mode);
    }

    /**
     * @throws MomentException
     */
    public function format($format = null): string
    {
        return $this->moment->format($format, new MomentJs());
    }

}