<?php

namespace Appleton\Taxes\Traits;

class HasWageBaseTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testHasWageBase($earnings, $ytd_earnings, $result)
    {
        $mock = new class {
            use HasWageBase;

            const WAGE_START = 50;
            const WAGE_BASE = 100;

            public $payroll;

            public function __construct()
            {
                $this->payroll = new class {
                    public $earnings = 0;
                    public $ytd_earnings = 0;
                    public function getEarnings()
                    {
                        return $this->earnings;
                    }
                    public function getYtdEarnings()
                    {
                        return $this->ytd_earnings;
                    }
                };
            }
        };

        $mock->payroll->earnings = $earnings;
        $mock->payroll->ytd_earnings = $ytd_earnings;

        $this->assertSame($result, $mock->getBaseEarnings());
    }

    public function provideTestData()
    {
        return [
            '0' => [
                1,
                0,
                0,
            ],
            '1' => [
                1,
                50,
                1,
            ],
            '2' => [
                1,
                99,
                1,
            ],
            '3' => [
                1,
                100,
                0,
            ],
        ];
    }
}
