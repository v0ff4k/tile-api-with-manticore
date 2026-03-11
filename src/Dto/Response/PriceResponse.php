<?php

declare(strict_types=1);

namespace App\Dto\Response;

/**
 * DTO ответа для цены товара.
 */
final readonly class PriceResponse
{
    public function __construct(
        public readonly float $price,
        public readonly string $factory,
        public readonly string $collection,
        public readonly string $article,
    ) {
    }
}
