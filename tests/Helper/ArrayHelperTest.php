<?php

namespace App\Tests\Helper;

use App\Helper\ArrayHelper;
use PHPUnit\Framework\TestCase;

class ArrayHelperTest extends TestCase
{
    public function testGetString(): void
    {
        $this->assertSame('x', ArrayHelper::getString(['a' => 'x'], 'a'));
        $this->assertSame('1', ArrayHelper::getString(['a' => 1], 'a'));
        $this->assertSame('d', ArrayHelper::getString([], 'a', 'd'));
        $this->assertNull(ArrayHelper::getString(['a' => []], 'a'));
    }

    public function testGetInt(): void
    {
        $this->assertSame(10, ArrayHelper::getInt(['a' => 10], 'a'));
        $this->assertSame(10, ArrayHelper::getInt(['a' => '10'], 'a'));
        $this->assertSame(7, ArrayHelper::getInt([], 'a', 7));
        $this->assertNull(ArrayHelper::getInt(['a' => 'x'], 'a'));
    }

    public function testGetFloat(): void
    {
        $this->assertSame(1.5, ArrayHelper::getFloat(['a' => 1.5], 'a'));
        $this->assertSame(1.5, ArrayHelper::getFloat(['a' => '1,5'], 'a'));
        $this->assertSame(2.0, ArrayHelper::getFloat(['a' => '2'], 'a'));
        $this->assertSame(7.0, ArrayHelper::getFloat([], 'a', 7.0));
        $this->assertNull(ArrayHelper::getFloat(['a' => 'x'], 'a'));
    }

    public function testGetArray(): void
    {
        $this->assertSame([1], ArrayHelper::getArray(['a' => [1]], 'a'));
        $this->assertSame([], ArrayHelper::getArray([], 'a'));
        $this->assertSame([2], ArrayHelper::getArray([], 'a', [2]));
        $this->assertSame([], ArrayHelper::getArray(['a' => 'x'], 'a'));
    }
}

