<?php

namespace hollisho\htranslator\Loaders;

use hollisho\htranslator\Exceptions\InvalidResourceException;
use hollisho\htranslator\Exceptions\NotFoundResourceException;

/**
 * @author Hollis
 * @desc
 * Interface LoaderInterface
 * @package hollisho\htranslator\Contracts
 */
interface LoaderInterface
{
    /**
     * Loads a locale.
     *
     * @throws NotFoundResourceException when the resource cannot be found
     * @throws InvalidResourceException  when the resource cannot be loaded
     */
    public function load($resource, string $locale, string $domain = 'messages');
}