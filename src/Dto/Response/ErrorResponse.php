<?php

declare(strict_types=1);

namespace App\Dto\Response;

/**
 * DTO ответа для ошибки.
 */
final readonly class ErrorResponse
{
    public function __construct(
        public readonly string $error,
        public readonly int $code,
    ) {
    }
}
