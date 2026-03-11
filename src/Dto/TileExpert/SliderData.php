<?php

declare(strict_types=1);

namespace App\Dto\TileExpert;

/**
 * DTO для данных слайдера.
 */
final readonly class SliderData
{
    /**
     * @param SliderElement[] $elements
     */
    public function __construct(
        public readonly array $elements = [],
    ) {
    }

    /**
     * Создание из массива данных.
     *
     * @param array<string, mixed> $data
     *
     * @throws \RuntimeException
     */
    public static function fromArray(array $data): self
    {
        if (!isset($data['elements']) || !is_array($data['elements'])) {
            throw new \RuntimeException('Invalid slider data: elements not found');
        }

        /** @var array<array<string, mixed>> $elementsData */
        $elementsData = $data['elements'];

        $elements = array_map(
            static fn (array $element): SliderElement => SliderElement::fromArray($element),
            $elementsData
        );

        return new self(elements: $elements);
    }

    /**
     * Получить первый элемент с ценой.
     */
    public function getFirstElementWithPrice(): ?SliderElement
    {
        foreach ($this->elements as $element) {
            if ($element->hasPrice()) {
                return $element;
            }
        }

        return null;
    }

    /**
     * Получить элемент по артикулу.
     */
    public function getElementByArticle(string $article): ?SliderElement
    {
        foreach ($this->elements as $element) {
            if ($element->article === $article) {
                return $element;
            }
        }

        return null;
    }
}
