<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\California\V20190101;

use Appleton\Taxes\Countries\US\California\SanFranciscoPayrollExpenseEmployer\SanFranciscoPayrollExpenseEmployer;
use Appleton\Taxes\Tests\Unit\Countries\PayrollLiabilityTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class SanFranciscoPayrollExpenseEmployerTest extends PayrollLiabilityTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.california.san_francisco';
    private const TAX_CLASS = SanFranciscoPayrollExpenseEmployer::class;

    /** @dataProvider dataProvider */
    public function testPayrollLiability(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public static function dataProvider(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS);

        return [
            'with ytd wages under start' => [
                $builder
                    ->setWagesInCents(100)
                    ->setYtdWagesInCents(29999899)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'with ytd wages equal start' => [
                $builder
                    ->setWagesInCents(100)
                    ->setYtdWagesInCents(29999900)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'with ytd wages over start' => [
                $builder
                    ->setWagesInCents(100)
                    ->setYtdWagesInCents(29999999)
                    ->setExpectedAmountInCents(1)
                    ->setExpectedEarningsInCents(99)
                    ->build(),
            ],
            'wages under start' => [
                $builder
                    ->setWagesInCents(29999000)
                    ->setYtdWagesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'wages equal start' => [
                $builder
                    ->setWagesInCents(30000000)
                    ->setYtdWagesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'wages over start' => [
                $builder
                    ->setWagesInCents(30000100)
                    ->setYtdWagesInCents(0)
                    ->setExpectedAmountInCents(1)
                    ->setExpectedEarningsInCents(100)
                    ->build(),
            ],
            'combined wages' => [
                $builder
                    ->setWagesInCents(20000000)
                    ->setYtdWagesInCents(20000000)
                    ->setExpectedAmountInCents(38000)
                    ->setExpectedEarningsInCents(10000000)
                    ->build(),
            ],
        ];
    }
}
