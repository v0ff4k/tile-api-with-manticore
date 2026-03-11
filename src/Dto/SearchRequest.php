<?php

declare(strict_types=1);

namespace App\Dto;

/**
 * Class SearchRequest
 * DTO для параметров поиска заказов.
 */
final class SearchRequest
{
    public const DEFAULT_QUERY = '';
    public const DEFAULT_PAGE  = 1;
    public const DEFAULT_LIMIT = 10;
    public const MAX_LIMIT     = 100;

    public function __construct(
        public readonly string $query = self::DEFAULT_QUERY,
        public readonly int $page = self::DEFAULT_PAGE,
        public readonly int $limit = self::DEFAULT_LIMIT,
    ) {
    }
}
