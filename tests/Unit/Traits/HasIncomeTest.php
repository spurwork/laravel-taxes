<?php

namespace Appleton\Taxes\Tests\Unit\Traits;

use Appleton\Taxes\Tests\Unit\UnitTestCase;
use Appleton\Taxes\Traits\HasIncome;

class HasIncomeTest extends UnitTestCase
{
    /** @dataProvider data */
    public function testGetTaxBracket(int $amount, array $expected): void
    {
        $mock = new class {
            use HasIncome;
        };

        $bracket = $mock->getTaxBracket($amount, [
            [0, 0, 0],
            [100, .1, 3],
            [200, 0.12, 4],
            [300, 0.13, 5],
        ]);
        self::assertEquals($bracket, $expected);
    }

    public static function data():array
    {
        return [
            '0' => [0, [0, 0, 0]],
            '99' => [99, [0, 0, 0]],
            '100' => [100, [100, .1, 3]],
            '101' => [101, [100, .1, 3]],
            '199' => [199, [100, .1, 3]],
            '200' => [200, [200, 0.12, 4]],
            '201' => [201, [200, 0.12, 4]],
            '299' => [299, [200, 0.12, 4]],
            '300' => [300, [300, 0.13, 5]],
            '301' => [301, [300, 0.13, 5]],
        ];
    }
}
