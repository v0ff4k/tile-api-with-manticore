<?php

namespace App\Tests\Helper;

use App\Helper\StrHelper;
use \PHPUnit\Framework\TestCase;

/**
 * Class StrHelperTest
 * @todo
 */
class StrHelperTest extends TestCase
{
    public static function getStringBetweenDataProvider(): array
    {

        // in: [ [ $expected, $string, $from, $to], ... ]
        return [
            ['проверка между тегами', '<div>проверка между тегами</div>', '<div>', '</div>'],
            ['', 'тоже:1>пров</ерка', ':0>', '</'],
            ['провер3', 'какая-то провер3 3', '-то ', ' 3'],
            ['юнико', 'ᰄюникода', 'ᰄ', 'да'],

            // wired examples
            ['', '', ' ', ''],
            ['', ' ', '', ' '],
            ['2', '0204060', '0', '0'],
            ['', '0204060', '2', '0'],//without space between start-end
            ['1020', '0102040', '0', '4'],
            //multibyte
            ['', 'ᰄюникода', '0', '0' ],
            ['', 'ᰄюникода', '', '0' ],
            ['юнико', 'ᰄюникода', 'ᰄ', 'да' ],
            ['8G', 'A:28G:0', '2', ':'],
            ['', 'ᰄпример', '', 'ер'],
        ];
    }

    /**
     * @dataProvider getStringBetweenDataProvider
     * @param $expected
     * @param $inputString
     * @param $from
     * @param $to
     */
    public function testGetStringBetween($expected, $inputString, $from, $to)
    {
        $this->assertSame($expected, StrHelper::getStringBetween($inputString, $from, $to));
    }
}
