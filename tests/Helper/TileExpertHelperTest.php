<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Helper\TileExpertHelper;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * Unit-тесты для TileExpertHelper
 *
 * @covers \App\Helper\TileExpertHelper
 */
class TileExpertHelperTest extends TestCase
{
    public function testExtractAppStoreJsonReturnsTileExpertData(): void
    {
        $html = $this->getSampleHtmlWithPrice(63.99);

        $result = TileExpertHelper::extractAppStoreJson($html);

        self::assertInstanceOf(\App\Dto\TileExpert\TileExpertData::class, $result);
        self::assertNotNull($result->slider);
        self::assertCount(1, $result->slider->elements);
    }

    public function testExtractAppStoreJsonWithComplexData(): void
    {
        $html = $this->getSampleHtmlWithMultipleElements(125.50);

        $result = TileExpertHelper::extractAppStoreJson($html);

        self::assertNotNull($result->slider);
        self::assertCount(3, $result->slider->elements);
        self::assertEquals(100.00, $result->slider->elements[0]->priceEuroIt);
        self::assertEquals(125.50, $result->slider->elements[1]->priceEuroIt);
    }

    public function testGetPriceFromTileExpertData(): void
    {
        $html   = $this->getSampleHtmlWithPrice(63.99);
        $result = TileExpertHelper::extractAppStoreJson($html);

        $price = $result->getPrice();

        self::assertEquals(63.99, $price);
    }

    public function testGetFirstElementWithPrice(): void
    {
        $html   = $this->getSampleHtmlWithMultipleElements(125.50);
        $result = TileExpertHelper::extractAppStoreJson($html);

        $element = $result->slider?->getFirstElementWithPrice();

        self::assertNotNull($element);
        self::assertEquals(100.00, $element->priceEuroIt);
    }

    public function testExtractAppStoreJsonThrowsExceptionWhenScriptNotFound(): void
    {
        $html = '<html><body><div>No script here</div></body></html>';

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('JSON data not found');

        TileExpertHelper::extractAppStoreJson($html);
    }

    public function testExtractAppStoreJsonThrowsExceptionWhenInvalidJson(): void
    {
        $html = '<html><body><script type="application/json" data-js-react-on-rails-store="appStore">not valid json</script></body></html>';

        // json_decode с JSON_THROW_ON_ERROR выбрасывает JsonException
        $this->expectException(\JsonException::class);

        TileExpertHelper::extractAppStoreJson($html);
    }

    public function testGetPriceThrowsExceptionWhenSliderNotFound(): void
    {
        $json = json_encode(['noSlider' => true], JSON_THROW_ON_ERROR);
        $html = sprintf(
            '<html><body><script type="application/json" data-js-react-on-rails-store="appStore">%s</script></body></html>',
            $json
        );
        $result = TileExpertHelper::extractAppStoreJson($html);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Slider data not found');

        $result->getPrice();
    }

    public function testGetPriceThrowsExceptionWhenPriceNotFound(): void
    {
        $json = json_encode([
            'slider' => [
                'elements' => [
                    ['name' => 'no-price', 'id' => '1'],
                ],
            ],
        ], JSON_THROW_ON_ERROR);
        $html = sprintf(
            '<html><body><script type="application/json" data-js-react-on-rails-store="appStore">%s</script></body></html>',
            $json
        );
        $result = TileExpertHelper::extractAppStoreJson($html);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Price not found in slider elements');

        $result->getPrice();
    }

    public function testSliderElementHasPrice(): void
    {
        $html   = $this->getSampleHtmlWithPrice(63.99);
        $result = TileExpertHelper::extractAppStoreJson($html);

        $element = $result->slider?->elements[0];

        self::assertTrue($element->hasPrice());
    }

    public function testSliderElementWithoutPrice(): void
    {
        $json = json_encode([
            'slider' => [
                'elements' => [
                    ['name' => 'test', 'id' => '1'],
                ],
            ],
        ], JSON_THROW_ON_ERROR);
        $html = sprintf(
            '<html><body><script type="application/json" data-js-react-on-rails-store="appStore">%s</script></body></html>',
            $json
        );
        $result = TileExpertHelper::extractAppStoreJson($html);

        $element = $result->slider?->elements[0];

        self::assertFalse($element->hasPrice());
    }

    public function testGetElementByArticle(): void
    {
        $html   = $this->getSampleHtmlWithMultipleElements(125.50);
        $result = TileExpertHelper::extractAppStoreJson($html);

        // Добавим артикул в тестовые данные
        $json = json_encode([
            'slider' => [
                'elements' => [
                    ['article' => 'ART-001', 'priceEuroIt' => 100.00],
                    ['article' => 'ART-002', 'priceEuroIt' => 125.50],
                ],
            ],
        ], JSON_THROW_ON_ERROR);
        $html = sprintf(
            '<html><body><script type="application/json" data-js-react-on-rails-store="appStore">%s</script></body></html>',
            $json
        );
        $result = TileExpertHelper::extractAppStoreJson($html);

        $element = $result->slider?->getElementByArticle('ART-002');

        self::assertNotNull($element);
        self::assertEquals('ART-002', $element->article);
    }

    /**
     * Получить sample HTML с ценой
     */
    private function getSampleHtmlWithPrice(float $price): string
    {
        $json = json_encode([
            'slider' => [
                'elements' => [
                    [
                        'priceEuroIt' => $price,
                        'article' => 'test-article',
                    ],
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        return sprintf(
            '<html><body><script type="application/json" data-js-react-on-rails-store="appStore">%s</script></body></html>',
            $json
        );
    }

    /**
     * Получить sample HTML с несколькими элементами
     */
    private function getSampleHtmlWithMultipleElements(float $price): string
    {
        $json = json_encode([
            'slider' => [
                'elements' => [
                    ['name' => 'element1', 'priceEuroIt' => 100.00],
                    ['name' => 'element2', 'priceEuroIt' => $price],
                    ['name' => 'element3', 'priceEuroIt' => 150.00],
                ],
            ],
        ], JSON_THROW_ON_ERROR);

        return sprintf(
            '<html><body><script type="application/json" data-js-react-on-rails-store="appStore">%s</script></body></html>',
            $json
        );
    }
}
