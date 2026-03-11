<?php

declare(strict_types=1);

namespace App\Dto\TileExpert;

/**
 * DTO для элемента слайдера.
 */
final readonly class SliderElement
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $name = null,
        public readonly ?float $priceEuroIt = null,
        public readonly ?string $article = null,
        /** @var array<string, mixed> */
        public readonly array $extraData = [],
    ) {
    }

    /**
     * Создание из массива данных.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: isset($data['id']) && is_scalar($data['id']) ? (string) $data['id'] : null,
            name: isset($data['name']) && is_scalar($data['name']) ? (string) $data['name'] : null,
            priceEuroIt: isset($data['priceEuroIt']) && is_numeric($data['priceEuroIt']) ? (float) $data['priceEuroIt'] : null,
            article: isset($data['article']) && is_scalar($data['article']) ? (string) $data['article'] : null,
            extraData: array_diff_key($data, array_flip(['id', 'name', 'priceEuroIt', 'article'])),
        );
    }

    public function hasPrice(): bool
    {
        return null !== $this->priceEuroIt;
    }
}
