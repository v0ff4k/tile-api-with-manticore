<?php

namespace App\Helper;

/**
 * Class ArrayHelper
 * @package App\Helper
 */
final class ArrayHelper
{
    /**
     * @param array $data
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
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

    /**
     * @param array $data
     * @param string $key
     * @param int|null $default
     * @return int|null
     */
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

    /**
     * @param array $data
     * @param string $key
     * @param float|null $default
     * @return float|null
     */
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
     * @param array $data
     * @param string $key
     * @param array $default
     * @return array
     */
    public static function getArray(array $data, string $key, array $default = []): array
    {
        if (!array_key_exists($key, $data) || $data[$key] === null) {
            return $default;
        }

        return is_array($data[$key]) ? $data[$key] : $default;
    }
}
