<?php

declare(strict_types=1);

namespace App\Dto;

/**
 * DTO для параметров группировки заказов.
 */
final readonly class GroupedOrdersRequest
{
    public const GROUP_BY_DAY     = 'day';
    public const GROUP_BY_MONTH   = 'month';
    public const GROUP_BY_YEAR    = 'year';
    public const ALLOWED_GROUP_BY = [
        self::GROUP_BY_DAY,
        self::GROUP_BY_MONTH,
        self::GROUP_BY_YEAR,
    ];
    public const DEFAULT_GROUP_BY = self::GROUP_BY_MONTH;

    public const DEFAULT_PAGE  = 1;
    public const DEFAULT_LIMIT = 10;
    public const MIN_PAGE      = 1;
    public const MIN_LIMIT     = 1;
    public const MAX_LIMIT     = 100;

    public function __construct(
        public readonly string $groupBy = self::DEFAULT_GROUP_BY,
        public readonly int $page = self::DEFAULT_PAGE,
        public readonly int $limit = self::DEFAULT_LIMIT,
    ) {
    }
}
