<?php
namespace hollisho\htranslator\Resources;


use InvalidArgumentException;

class FileResource implements ResourceInterface
{

    /**
     * @var string|false
     */
    private $resource;

    /**
     * @param string $resource The file path to the resource
     *
     * @throws InvalidArgumentException
     */
    public function __construct(string $resource)
    {
        $this->resource = realpath($resource) ?: (file_exists($resource) ? $resource : false);

        if (false === $this->resource) {
            throw new InvalidArgumentException(sprintf('The file "%s" does not exist.', $resource));
        }
    }

    public function __toString(): string
    {
        return $this->resource;
    }

    /**
     * Returns the canonicalized, absolute path to the resource.
     */
    public function getResource(): string
    {
        return $this->resource;
    }

    /**
     * {@inheritdoc}
     */
    public function isFresh(int $timestamp): bool
    {
        return false !== ($filemtime = @filemtime($this->resource)) && $filemtime <= $timestamp;
    }

}