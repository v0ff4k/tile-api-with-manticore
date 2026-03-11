<?php

declare(strict_types=1);

namespace App\Dto;

/**
 * DTO для параметров запроса цены.
 */
final readonly class PriceRequest
{
    public const MIN_LENGTH = 1;
    public const MAX_LENGTH = 255;

    public function __construct(
        public readonly string $factory,
        public readonly string $collection,
        public readonly string $article,
    ) {
    }

    /**
     * Валидация параметров.
     */
    public function isValid(): bool
    {
        return '' !== $this->factory
            && '' !== $this->collection
            && '' !== $this->article
            && strlen($this->factory) <= self::MAX_LENGTH
            && strlen($this->collection) <= self::MAX_LENGTH
            && strlen($this->article) <= self::MAX_LENGTH;
    }
}
