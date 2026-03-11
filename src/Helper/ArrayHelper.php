<?php

namespace App\Helper;

final class ArrayHelper
{
    public static function getString(array $data, string $key, ?string $default = null): ?string
    {
        if (!array_key_exists($key, $data) || $data[$key] === null) {
            return $default;
        }

        if (is_string($data[$key])) {
            return $data[$key];
        }

        if (is_scalar($data[$key])) {
            return (string) $data[$key];
        }

        return $default;
    }

    public static function getInt(array $data, string $key, ?int $default = null): ?int
    {
        if (!array_key_exists($key, $data) || $data[$key] === null) {
            return $default;
        }

        if (is_int($data[$key])) {
            return $data[$key];
        }

        if (is_numeric($data[$key])) {
            return (int) $data[$key];
        }

        return $default;
    }

    public static function getFloat(array $data, string $key, ?float $default = null): ?float
    {
        if (!array_key_exists($key, $data) || $data[$key] === null) {
            return $default;
        }

        if (is_float($data[$key]) || is_int($data[$key])) {
            return (float) $data[$key];
        }

        if (is_string($data[$key])) {
            $normalized = str_replace(',', '.', trim($data[$key]));
            if (is_numeric($normalized)) {
                return (float) $normalized;
            }
        }

        return $default;
    }

    /**
     * @return array<mixed>
     */
    public static function getArray(array $data, string $key, array $default = []): array
    {
        if (!array_key_exists($key, $data) || $data[$key] === null) {
            return $default;
        }

        return is_array($data[$key]) ? $data[$key] : $default;
    }
}

