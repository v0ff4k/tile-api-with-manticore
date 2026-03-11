<?php

declare(strict_types=1);

namespace App\Helper;

use App\Dto\TileExpert\TileExpertData;

/**
 * Helper для извлечения данных из TileExpert.
 */
final class TileExpertHelper
{
    /**
     * Извлечь данные из JSON в HTML.
     *
     * @throws \RuntimeException
     */
    public static function extractAppStoreJson(string $html): TileExpertData
    {
        $json = self::extractJsonString($html);
        $data = self::decodeJson($json);

        return TileExpertData::fromArray($data);
    }

    /**
     * Извлечь JSON строку из HTML.
     *
     * @throws \RuntimeException
     */
    private static function extractJsonString(string $html): string
    {
        // Попытка найти через строку между тегами
        $json = StrHelper::getStringBetween(
            $html,
            '<script type="application/json" data-js-react-on-rails-store="appStore">',
            '</script>'
        );

        if (false !== $json && '' !== $json) {
            return (string) $json;
        }

        // Fallback: regex
        if (!preg_match('/<script type="application\/json" data-js-react-on-rails-store="appStore">(.*?)<\/script>/s', $html, $matches)) {
            throw new \RuntimeException('JSON data not found');
        }

        return $matches[1];
    }

    /**
     * Декодировать JSON в массив.
     *
     * @return array<string, mixed>
     */
    private static function decodeJson(string $json): array
    {
        /** @var array<string, mixed> $data */
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        return $data;
    }
}
