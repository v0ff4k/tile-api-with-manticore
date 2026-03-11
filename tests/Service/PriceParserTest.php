<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\PriceParser;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;

/**
 * Unit-тесты для PriceParser
 *
 * @covers \App\Service\PriceParser
 */
class PriceParserTest extends TestCase
{
    private HttpClientInterface&MockObject $httpClient;
    private PriceParser $parser;
    private string $dataDir;

    protected function setUp(): void
    {
        $this->httpClient = $this->createMock(HttpClientInterface::class);
        $this->dataDir    = 'https://tile.expert/it/tile';
        $this->parser     = new PriceParser($this->httpClient, $this->dataDir);
    }

    public function testParseReturnsPriceWhenFound(): void
    {
        $factory       = 'marca-corona';
        $collection    = 'arteseta';
        $article       = 'k263-arteseta-camoscio';
        $expectedPrice = 63.99;

        $html = $this->getSampleHtmlWithPrice($expectedPrice);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')
            ->willReturn(200);
        $response->method('getContent')
            ->willReturn($html);

        $this->httpClient->expects(self::once())
            ->method('request')
            ->with('GET', $this->dataDir . '/' . $factory . '/' . $collection . '/a/' . $article)
            ->willReturn($response);

        $price = $this->parser->parse($factory, $collection, $article);

        self::assertEquals($expectedPrice, $price);
    }

    public function testParseThrowsExceptionWhenPriceNotFound(): void
    {
        $factory    = 'marca-corona';
        $collection = 'arteseta';
        $article    = 'non-existent';

        $html = $this->getSampleHtmlWithoutPrice();

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')
            ->willReturn(200);
        $response->method('getContent')
            ->willReturn($html);

        $this->httpClient->expects(self::once())
            ->method('request')
            ->willReturn($response);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Price not found');

        $this->parser->parse($factory, $collection, $article);
    }

    public function testParseThrowsExceptionWhenHttpError(): void
    {
        $factory    = 'marca-corona';
        $collection = 'arteseta';
        $article    = 'test';

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')
            ->willReturn(404);

        $this->httpClient->expects(self::once())
            ->method('request')
            ->willReturn($response);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Failed to fetch page');

        $this->parser->parse($factory, $collection, $article);
    }

    public function testParseThrowsExceptionOnTransportError(): void
    {
        $factory    = 'marca-corona';
        $collection = 'arteseta';
        $article    = 'test';

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')
            ->willThrowException($this->createMock(TransportExceptionInterface::class));

        $this->httpClient->expects(self::once())
            ->method('request')
            ->willReturn($response);

        $this->expectException(RuntimeException::class);

        $this->parser->parse($factory, $collection, $article);
    }

    public function testParseThrowsExceptionOnClientError(): void
    {
        $factory    = 'marca-corona';
        $collection = 'arteseta';
        $article    = 'test';

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')
            ->willThrowException($this->createMock(ClientExceptionInterface::class));

        $this->httpClient->expects(self::once())
            ->method('request')
            ->willReturn($response);

        $this->expectException(RuntimeException::class);

        $this->parser->parse($factory, $collection, $article);
    }

    public function testParseThrowsExceptionWhenInvalidJsonStructure(): void
    {
        $factory    = 'marca-corona';
        $collection = 'arteseta';
        $article    = 'test';

        $html = '<script type="application/json" data-js-react-on-rails-store="appStore">{"invalid": "structure"}</script>';

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')
            ->willReturn(200);
        $response->method('getContent')
            ->willReturn($html);

        $this->httpClient->expects(self::once())
            ->method('request')
            ->willReturn($response);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Slider data not found');

        $this->parser->parse($factory, $collection, $article);
    }

    public function testParseWithMultipleElementsInSlider(): void
    {
        $factory       = 'factory';
        $collection    = 'collection';
        $article       = 'article';
        $expectedPrice = 100.00; // Первый элемент в списке

        $html = $this->getSampleHtmlWithMultipleElements($expectedPrice);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')
            ->willReturn(200);
        $response->method('getContent')
            ->willReturn($html);

        $this->httpClient->expects(self::once())
            ->method('request')
            ->willReturn($response);

        $price = $this->parser->parse($factory, $collection, $article);

        // Метод возвращает цену первого элемента с priceEuroIt
        self::assertEquals($expectedPrice, $price);
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
     * Получить sample HTML без цены
     */
    private function getSampleHtmlWithoutPrice(): string
    {
        $json = json_encode([
            'slider' => [
                'elements' => [
                    [
                        'name' => 'test',
                        'noPrice' => true,
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
