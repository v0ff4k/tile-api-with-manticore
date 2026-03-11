<?php

declare(strict_types=1);

namespace App\Dto\Response;

/**
 * DTO ответа для группированных заказов.
 */
final readonly class GroupedOrdersResponse
{
    /**
     * @param array<array{period: string, count: int}> $data
     */
    public function __construct(
        public readonly int $page,
        public readonly int $limit,
        public readonly int $total,
        public readonly int $pages,
        public readonly array $data,
    ) {
    }

    /**
     * Создание из массива данных репозитория.
     *
     * @param array{page: int, limit: int, total: int, pages: int, data: array<array{period: string, count: int}>} $result
     */
    public static function fromArray(array $result): self
    {
        return new self(
            page: $result['page'],
            limit: $result['limit'],
            total: $result['total'],
            pages: $result['pages'],
            data: $result['data'],
        );
    }
}
