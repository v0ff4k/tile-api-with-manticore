<?php

declare(strict_types=1);

namespace App\Dto\TileExpert;

/**
 * DTO для данных из TileExpert.
 */
final readonly class TileExpertData
{
    public function __construct(
        public readonly ?SliderData $slider = null,
        /** @var array<string, mixed> */
        public readonly array $extraData = [],
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
        $slider = null;
        if (isset($data['slider']) && is_array($data['slider'])) {
            /** @var array<string, mixed> $sliderData */
            $sliderData = $data['slider'];
            $slider     = SliderData::fromArray($sliderData);
        }

        $extraData = array_diff_key($data, ['slider' => true]);

        return new self(
            slider: $slider,
            extraData: $extraData,
        );
    }

    /**
     * Получить цену первого элемента слайдера.
     *
     * @throws \RuntimeException
     */
    public function getPrice(): float
    {
        if (null === $this->slider) {
            throw new \RuntimeException('Slider data not found');
        }

        $element = $this->slider->getFirstElementWithPrice();

        if (null === $element || null === $element->priceEuroIt) {
            throw new \RuntimeException('Price not found in slider elements');
        }

        return $element->priceEuroIt;
    }
}
