<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Helper\StrHelper;
use PHPUnit\Framework\TestCase;

/**
 * Unit-тесты для StrHelper
 *
 * @covers \App\Helper\StrHelper
 */
class StrHelperTest extends TestCase
{
    public function testGetStringBetweenReturnsCorrectSubstring(): void
    {
        $string = 'Hello [START]world[END] Goodbye';
        $from   = '[START]';
        $end    = '[END]';

        $result = StrHelper::getStringBetween($string, $from, $end);

        self::assertEquals('world', $result);
    }

    public function testGetStringBetweenWithEmptyFromReturnsEmpty(): void
    {
        $string = 'Hello world';
        $from   = '';
        $end    = 'world';

        $result = StrHelper::getStringBetween($string, $from, $end);

        self::assertEquals('', $result);
    }

    public function testGetStringBetweenWithEmptyEndReturnsEmpty(): void
    {
        $string = 'Hello world';
        $from   = 'Hello';
        $end    = '';

        $result = StrHelper::getStringBetween($string, $from, $end);

        self::assertEquals('', $result);
    }

    public function testGetStringBetweenWhenFromNotFound(): void
    {
        $string = 'Hello world';
        $from   = '[NOTFOUND]';
        $end    = 'world';

        $result = StrHelper::getStringBetween($string, $from, $end);

        self::assertEquals('', $result);
    }

    public function testGetStringBetweenWhenEndNotFound(): void
    {
        $string = 'Hello [START]world';
        $from   = '[START]';
        $end    = '[END]';

        $result = StrHelper::getStringBetween($string, $from, $end);

        self::assertEquals('', $result);
    }

    public function testGetStringBetweenWithMultipleOccurrences(): void
    {
        $string = '[START]first[END] middle [START]second[END]';
        $from   = '[START]';
        $end    = '[END]';

        $result = StrHelper::getStringBetween($string, $from, $end);

        self::assertEquals('first', $result);
    }

    public function testGetStringBetweenWithSpecialCharacters(): void
    {
        $string = '<div>content</div>';
        $from   = '<div>';
        $end    = '</div>';

        $result = StrHelper::getStringBetween($string, $from, $end);

        self::assertEquals('content', $result);
    }

    public function testGetStringBetweenWithJsonContent(): void
    {
        $json   = '{"key": "value"}';
        $string = '<script>' . $json . '</script>';
        $from   = '<script>';
        $end    = '</script>';

        $result = StrHelper::getStringBetween($string, $from, $end);

        self::assertEquals($json, $result);
    }

    public function testGetRandomUserAgentStringReturnsString(): void
    {
        $result = StrHelper::getRandomUserAgentString();

        self::assertIsString($result);
        self::assertNotEmpty($result);
        self::assertStringStartsWith('Mozilla/5.0', $result);
    }

    public function testGetRandomUserAgentStringWithUseRandFalse(): void
    {
        $result1 = StrHelper::getRandomUserAgentString(false);
        $result2 = StrHelper::getRandomUserAgentString(false);

        self::assertEquals($result1, $result2);
    }

    public function testGetRandomUserAgentStringWithUseRandTrue(): void
    {
        $result1 = StrHelper::getRandomUserAgentString(true);
        $result2 = StrHelper::getRandomUserAgentString(true);

        // Может быть одинаковым, но обычно разным
        self::assertIsString($result1);
        self::assertIsString($result2);
    }

    public function testGetRandomUserAgentStringContainsExpectedPatterns(): void
    {
        $result = StrHelper::getRandomUserAgentString();

        // Проверяем, что User-Agent содержит типичные паттерны
        self::assertMatchesRegularExpression(
            '/(Firefox|Chrome|Safari|MSIE|Trident|AppleWebKit|CriOS|Vivaldi)/',
            $result
        );
    }

    public function testGetUrlAsString(): void
    {
        // Этот тест требует реального HTTP-запроса
        // Можно пропустить в CI/CD окружении
        if (getenv('CI') === 'true') {
            self::markTestSkipped('Skipping HTTP test in CI environment');
        }

        $url    = 'https://example.com';
        $result = StrHelper::getUrlAsString($url);

        self::assertIsString($result);
        self::assertNotEmpty($result);
    }
}
