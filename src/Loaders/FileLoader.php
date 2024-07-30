<?php

namespace hollisho\htranslator\Loaders;

use hollisho\htranslator\Catelogues\MessageCatalogue;
use hollisho\htranslator\Exceptions\InvalidResourceException;
use hollisho\htranslator\Exceptions\NotFoundResourceException;
use hollisho\htranslator\Resources\FileResource;

/**
 * @author Hollis
 * @desc 文件类型-基础数据加载器
 * Class FileLoader
 * @package hollisho\htranslator\Loaders
 */
abstract class FileLoader extends ArrayLoader
{
    /**
     * {@inheritdoc}
     */
    public function load($resource, string $locale, string $domain = 'messages'): MessageCatalogue
    {
        if (!stream_is_local($resource)) {
            throw new InvalidResourceException(sprintf('This is not a local file "%s".', $resource));
        }

        if (!file_exists($resource)) {
            throw new NotFoundResourceException(sprintf('File "%s" not found.', $resource));
        }

        $messages = $this->loadResource($resource);

        // empty resource
        if (null === $messages) {
            $messages = [];
        }

        // not an array
        if (!\is_array($messages)) {
            throw new InvalidResourceException(sprintf('Unable to load file "%s".', $resource));
        }

        $catalogue = parent::load($messages, $locale, $domain);

        if (class_exists(FileResource::class)) {
            $catalogue->addResource(new FileResource($resource));
        }

        return $catalogue;
    }

    /**
     * @return array
     *
     * @throws InvalidResourceException if stream content has an invalid format
     */
    abstract protected function loadResource(string $resource);

}