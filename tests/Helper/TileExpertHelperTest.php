<?php

namespace App\Tests\Helper;

use App\Helper\TileExpertHelper;
use PHPUnit\Framework\TestCase;

class TileExpertHelperTest extends TestCase
{
    public function testExtractAppStoreJsonSuccess(): void
    {
        $html = '<html><head></head><body>'
            . '<script type="application/json" data-js-react-on-rails-store="appStore">'
            . '{"slider":{"elements":[{"priceEuroIt":59.99}]}}'
            . '</script>'
            . '</body></html>';

        $data = TileExpertHelper::extractAppStoreJson($html);
        $this->assertSame(59.99, $data['slider']['elements'][0]['priceEuroIt']);
    }

    public function testExtractAppStoreJsonNotFound(): void
    {
        $this->expectException(\RuntimeException::class);
        TileExpertHelper::extractAppStoreJson('<html></html>');
    }

    public function testExtractAppStoreJsonInvalidJson(): void
    {
        $this->expectException(\RuntimeException::class);
        $html = '<script type="application/json" data-js-react-on-rails-store="appStore">{bad}</script>';
        TileExpertHelper::extractAppStoreJson($html);
    }
}

