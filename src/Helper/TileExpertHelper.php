<?php

namespace App\Helper;

final class TileExpertHelper
{
    /**
     * @return array<mixed>
     */
    public static function extractAppStoreJson(string $html): array
    {
        $json = StrHelper::getStringBetween(
            $html,
            '<script type="application/json" data-js-react-on-rails-store="appStore">',
            '</script>'
        );

        if ($json === '') {
            if (!preg_match('/<script type="application\/json" data-js-react-on-rails-store="appStore">(.*?)<\/script>/s', $html, $m)) {
                throw new \RuntimeException('JSON data not found');
            }
            $json = $m[1];
        }

        $data = json_decode($json, true);
        if (!is_array($data)) {
            throw new \RuntimeException('Invalid JSON');
        }

        return $data;
    }
}

