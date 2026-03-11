<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Helper\ArrayHelper;
use PHPUnit\Framework\TestCase;

/**
 * Unit-тесты для ArrayHelper
 *
 * @covers \App\Helper\ArrayHelper
 */
class ArrayHelperTest extends TestCase
{
    // ==================== getString ====================

    public function testGetStringReturnsStringValue(): void
    {
        $data   = ['name' => 'test'];
        $result = ArrayHelper::getString($data, 'name');

        self::assertEquals('test', $result);
    }

    public function testGetStringReturnsDefaultWhenKeyNotFound(): void
    {
        $data   = ['other' => 'value'];
        $result = ArrayHelper::getString($data, 'name', 'default');

        self::assertEquals('default', $result);
    }

    public function testGetStringReturnsNullWhenKeyNotFoundNoDefault(): void
    {
        $data   = ['other' => 'value'];
        $result = ArrayHelper::getString($data, 'name');

        self::assertNull($result);
    }

    public function testGetStringReturnsDefaultWhenValueIsNull(): void
    {
        $data   = ['name' => null];
        $result = ArrayHelper::getString($data, 'name', 'default');

        self::assertEquals('default', $result);
    }

    public function testGetStringConvertsIntToString(): void
    {
        $data   = ['count' => 42];
        $result = ArrayHelper::getString($data, 'count');

        self::assertEquals('42', $result);
    }

    public function testGetStringConvertsFloatToString(): void
    {
        $data   = ['price' => 19.99];
        $result = ArrayHelper::getString($data, 'price');

        self::assertEquals('19.99', $result);
    }

    public function testGetStringConvertsBoolToString(): void
    {
        $data   = ['active' => true];
        $result = ArrayHelper::getString($data, 'active');

        self::assertEquals('1', $result);
    }

    public function testGetStringReturnsDefaultForArray(): void
    {
        $data   = ['items' => [1, 2, 3]];
        $result = ArrayHelper::getString($data, 'items', 'default');

        self::assertEquals('default', $result);
    }

    public function testGetStringReturnsDefaultForObject(): void
    {
        $data   = ['object' => (object) ['key' => 'value']];
        $result = ArrayHelper::getString($data, 'object', 'default');

        self::assertEquals('default', $result);
    }

    public function testGetStringWithEmptyString(): void
    {
        $data   = ['name' => ''];
        $result = ArrayHelper::getString($data, 'name', 'default');

        self::assertEquals('', $result);
    }

    // ==================== getInt ====================

    public function testGetIntReturnsIntValue(): void
    {
        $data   = ['count' => 42];
        $result = ArrayHelper::getInt($data, 'count');

        self::assertEquals(42, $result);
    }

    public function testGetIntReturnsDefaultWhenKeyNotFound(): void
    {
        $data   = ['other' => 'value'];
        $result = ArrayHelper::getInt($data, 'count', 0);

        self::assertEquals(0, $result);
    }

    public function testGetIntReturnsNullWhenKeyNotFoundNoDefault(): void
    {
        $data   = ['other' => 'value'];
        $result = ArrayHelper::getInt($data, 'count');

        self::assertNull($result);
    }

    public function testGetIntReturnsDefaultWhenValueIsNull(): void
    {
        $data   = ['count' => null];
        $result = ArrayHelper::getInt($data, 'count', 0);

        self::assertEquals(0, $result);
    }

    public function testGetIntConvertsNumericStringToInt(): void
    {
        $data   = ['count' => '42'];
        $result = ArrayHelper::getInt($data, 'count');

        self::assertEquals(42, $result);
    }

    public function testGetIntConvertsFloatToInt(): void
    {
        $data   = ['count' => 42.99];
        $result = ArrayHelper::getInt($data, 'count');

        self::assertEquals(42, $result);
    }

    public function testGetIntReturnsDefaultForNonNumericString(): void
    {
        $data   = ['count' => 'abc'];
        $result = ArrayHelper::getInt($data, 'count', 0);

        self::assertEquals(0, $result);
    }

    public function testGetIntReturnsDefaultForArray(): void
    {
        $data   = ['count' => [1, 2, 3]];
        $result = ArrayHelper::getInt($data, 'count', 0);

        self::assertEquals(0, $result);
    }

    public function testGetIntWithZero(): void
    {
        $data   = ['count' => 0];
        $result = ArrayHelper::getInt($data, 'count');

        self::assertEquals(0, $result);
    }

    public function testGetIntWithNegativeNumber(): void
    {
        $data   = ['count' => -5];
        $result = ArrayHelper::getInt($data, 'count');

        self::assertEquals(-5, $result);
    }

    // ==================== getFloat ====================

    public function testGetFloatReturnsFloatValue(): void
    {
        $data   = ['price' => 19.99];
        $result = ArrayHelper::getFloat($data, 'price');

        self::assertEquals(19.99, $result);
    }

    public function testGetFloatReturnsDefaultWhenKeyNotFound(): void
    {
        $data   = ['other' => 'value'];
        $result = ArrayHelper::getFloat($data, 'price', 0.0);

        self::assertEquals(0.0, $result);
    }

    public function testGetFloatReturnsNullWhenKeyNotFoundNoDefault(): void
    {
        $data   = ['other' => 'value'];
        $result = ArrayHelper::getFloat($data, 'price');

        self::assertNull($result);
    }

    public function testGetFloatReturnsDefaultWhenValueIsNull(): void
    {
        $data   = ['price' => null];
        $result = ArrayHelper::getFloat($data, 'price', 0.0);

        self::assertEquals(0.0, $result);
    }

    public function testGetFloatConvertsIntToFloat(): void
    {
        $data   = ['price' => 100];
        $result = ArrayHelper::getFloat($data, 'price');

        self::assertEquals(100.0, $result);
    }

    public function testGetFloatConvertsStringWithDotToFloat(): void
    {
        $data   = ['price' => '19.99'];
        $result = ArrayHelper::getFloat($data, 'price');

        self::assertEquals(19.99, $result);
    }

    public function testGetFloatConvertsStringWithCommaToFloat(): void
    {
        $data   = ['price' => '19,99'];
        $result = ArrayHelper::getFloat($data, 'price');

        self::assertEquals(19.99, $result);
    }

    public function testGetFloatConvertsStringWithSpacesAndComma(): void
    {
        $data   = ['price' => ' 19,99 '];
        $result = ArrayHelper::getFloat($data, 'price');

        self::assertEquals(19.99, $result);
    }

    public function testGetFloatReturnsDefaultForNonNumericString(): void
    {
        $data   = ['price' => 'abc'];
        $result = ArrayHelper::getFloat($data, 'price', 0.0);

        self::assertEquals(0.0, $result);
    }

    public function testGetFloatReturnsDefaultForArray(): void
    {
        $data   = ['price' => [1, 2, 3]];
        $result = ArrayHelper::getFloat($data, 'price', 0.0);

        self::assertEquals(0.0, $result);
    }

    public function testGetFloatWithZero(): void
    {
        $data   = ['price' => 0.0];
        $result = ArrayHelper::getFloat($data, 'price');

        self::assertEquals(0.0, $result);
    }

    public function testGetFloatWithNegativeNumber(): void
    {
        $data   = ['price' => -19.99];
        $result = ArrayHelper::getFloat($data, 'price');

        self::assertEquals(-19.99, $result);
    }

    // ==================== getArray ====================

    public function testGetArrayReturnsArrayValue(): void
    {
        $data   = ['items' => [1, 2, 3]];
        $result = ArrayHelper::getArray($data, 'items');

        self::assertEquals([1, 2, 3], $result);
    }

    public function testGetArrayReturnsDefaultWhenKeyNotFound(): void
    {
        $data   = ['other' => 'value'];
        $result = ArrayHelper::getArray($data, 'items', ['default']);

        self::assertEquals(['default'], $result);
    }

    public function testGetArrayReturnsEmptyArrayWhenKeyNotFoundNoDefault(): void
    {
        $data   = ['other' => 'value'];
        $result = ArrayHelper::getArray($data, 'items');

        self::assertEquals([], $result);
    }

    public function testGetArrayReturnsDefaultWhenValueIsNull(): void
    {
        $data   = ['items' => null];
        $result = ArrayHelper::getArray($data, 'items', ['default']);

        self::assertEquals(['default'], $result);
    }

    public function testGetArrayReturnsDefaultForString(): void
    {
        $data   = ['items' => 'string'];
        $result = ArrayHelper::getArray($data, 'items', []);

        self::assertEquals([], $result);
    }

    public function testGetArrayReturnsDefaultForInt(): void
    {
        $data   = ['items' => 42];
        $result = ArrayHelper::getArray($data, 'items', []);

        self::assertEquals([], $result);
    }

    public function testGetArrayWithEmptyArray(): void
    {
        $data   = ['items' => []];
        $result = ArrayHelper::getArray($data, 'items');

        self::assertEquals([], $result);
    }

    public function testGetArrayWithAssociativeArray(): void
    {
        $data   = ['config' => ['key' => 'value', 'nested' => ['a' => 1]]];
        $result = ArrayHelper::getArray($data, 'config');

        self::assertEquals(['key' => 'value', 'nested' => ['a' => 1]], $result);
    }

    public function testGetArrayWithMultidimensionalArray(): void
    {
        $data   = ['matrix' => [[1, 2], [3, 4]]];
        $result = ArrayHelper::getArray($data, 'matrix');

        self::assertEquals([[1, 2], [3, 4]], $result);
    }
}
