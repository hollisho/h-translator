<?php

namespace hollisho\htranslator;

use hollisho\htranslator\Catelogues\MessageCatalogue;
use hollisho\htranslator\Catelogues\MessageCatalogueInterface;
use hollisho\htranslator\Exceptions\NotFoundResourceException;
use hollisho\htranslator\Formatters\FormatterInterface;
use hollisho\htranslator\Formatters\MessageFormatter;
use hollisho\htranslator\Loaders\LoaderInterface;
use hollisho\htranslator\Locale\LocaleAwareInterface;
use hollisho\htranslator\Locale\LocaleManager;
use hollisho\htranslator\Resources\ResourceVo;
use hollisho\objectbuilder\Exceptions\BuilderException;
use hollisho\htranslator\Exceptions\InvalidResourceException;
use InvalidArgumentException;
use RuntimeException;


class Translator implements TranslatorInterface, LocaleAwareInterface
{

    protected $catalogues = [];

    /**
     * @var LocaleManager
     */
    private $locale_manager;

    private $formatter;

    /**
     * @var LoaderInterface[]
     */
    private $loaders = [];

    /**
     * @var array
     */
    private $resources = [];

    /**
     * @var string[]
     */
    private $fallback_locales = [];

    /**
     * @param LocaleManager|null $locale_manager
     * @param FormatterInterface|null $formatter
     */
    public function __construct(?LocaleManager $locale_manager = null, ?FormatterInterface $formatter = null)
    {
        if (null === $locale_manager) {
            $locale_manager = new LocaleManager();
        }

        $this->locale_manager = $locale_manager;

        if (null === $formatter) {
            $formatter = new MessageFormatter();
        }

        $this->formatter = $formatter;
    }

    /**
     * @param string|null $id
     * @param string|null $domain
     * @param string|null $locale
     * @return bool
     * @desc
     */
    public function has(?string $id, ?string $domain = null, ?string $locale = null): bool
    {
        /** @var MessageCatalogueInterface $catalogue */
        $catalogue = $this->getCatalogue($locale);
        return $catalogue->has($id, $domain);
    }

    /**
     * @param string|null $id
     * @param array $parameters
     * @param string|null $domain
     * @param string|null $locale
     * @return string
     * @author Hollis
     * @desc
     */
    public function trans(?string $id, array $parameters = [], ?string $domain = null, ?string $locale = null): string
    {
        if (null === $id || '' === $id) {
            return '';
        }

        if (null === $domain) {
            $domain = 'messages';
        }

        /** @var MessageCatalogueInterface $catalogue */
        $catalogue = $this->getCatalogue($locale);
        $locale = $catalogue->getLocale();
        while (!$catalogue->defines($id, $domain)) {
            if ($cat = $catalogue->getFallbackCatalogue()) {
                $catalogue = $cat;
                $locale = $catalogue->getLocale();
            } else {
                break;
            }
        }

        return $this->formatter->format($catalogue->get($id, $domain), $locale, $parameters);
    }

    /**
     * Asserts that the locale is valid, throws an Exception if not.
     *
     * @throws InvalidArgumentException If the locale contains invalid characters
     */
    protected function assertValidLocale(string $locale): void
    {
        if (!preg_match('/^[a-z0-9@_\\.\\-]*$/i', $locale)) {
            throw new InvalidArgumentException(sprintf('Invalid "%s" locale.', $locale));
        }
    }

    /**
     * @param string $locale
     * @author Hollis
     * @desc
     */
    public function setLocale(string $locale): void
    {
        $this->assertValidLocale($locale);
        $this->locale_manager->setLocale($locale);
    }

    /**
     * @return string
     * @author Hollis
     * @desc
     */
    public function getLocale(): string
    {
        return $this->locale_manager->getLocale();
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->locale_manager->reset();
    }


    /**
     * @param string|null $locale
     * @return mixed
     * @desc
     */
    public function getCatalogue(?string $locale = null)
    {
        if (!$locale) {
            $locale = $this->getLocale();
        } else {
            $this->assertValidLocale($locale);
        }

        if (!isset($this->catalogues[$locale])) {
            $this->initializeCatalogue($locale);
        }

        return $this->catalogues[$locale];
    }

    /**
     * @param string $locale
     * @return void
     * @throws InvalidResourceException
     * @throws NotFoundResourceException
     * @desc 加载内容目录
     */
    protected function loadCatalogue(string $locale)
    {
        $this->catalogues[$locale] = new MessageCatalogue($locale);

        if (isset($this->resources[$locale])) {
            /** @var ResourceVo $resource */
            foreach ($this->resources[$locale] as $resource) {
                if (!isset($this->loaders[$resource->format])) {
                    if (\is_string($resource->resource)) {
                        throw new RuntimeException(sprintf('No loader is registered for the "%s" format when loading the "%s" resource.',
                            $resource->format, $resource->resource));
                    }

                    throw new RuntimeException(sprintf('No loader is registered for the "%s" format.', $resource->format));
                }
                $this->catalogues[$locale]->addCatalogue($this->loaders[$resource->format]->load($resource->resource, $locale, $resource->domain));
            }
        }

    }


    /**
     * @param string $locale
     * @return void
     * @desc 初始化内容目录
     */
    protected function initializeCatalogue(string $locale)
    {
        $this->assertValidLocale($locale);

        try {
            $this->loadCatalogue($locale);
        } catch (\Exception $e) {
        }
    }

    /**
     * Adds a Loader.
     *
     * @param string $format The name of the loader (@see addResource())
     */
    public function addLoader(string $format, LoaderInterface $loader)
    {
        $this->loaders[$format] = $loader;
    }

    /**
     * @param string $format
     * @param $resource
     * @param string|null $locale
     * @param string|null $domain
     * @return void
     * @throws BuilderException
     * @author Hollis
     * @desc
     */
    public function addResource(string $format, $resource, ?string $locale = null, ?string $domain = null)
    {
        if (null === $domain) {
            $domain = 'messages';
        }

        $locale ?: $this->locale_manager->getDefaultLocale();
        $this->assertValidLocale($locale);

        $this->resources[$locale][] = ResourceVo::build([
            'format' => $format,
            'resource' => $resource,
            'domain' => $domain,
        ]);

        if (\in_array($locale, $this->fallback_locales)) {
            $this->catalogues = [];
        } else {
            unset($this->catalogues[$locale]);
        }

    }

}


