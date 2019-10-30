<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Nevada\V20190101;

use Appleton\Taxes\Countries\US\Nevada\NevadaGrossPayrollEmployer\NevadaGrossPayrollEmployer;
use Appleton\Taxes\Tests\Unit\Countries\PayrollLiabilityTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class NevadaGrossPayrollEmployerTest extends PayrollLiabilityTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.nevada';
    private const TAX_CLASS = NevadaGrossPayrollEmployer::class;

    /** @dataProvider dataProvider */
    public function testLiability(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function dataProvider(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS);

        return [
            'with qtd wages under start' => [
                $builder
                    ->setWagesInCents(100)
                    ->setQtdWageInCents(4999800)
                    ->setExpectedAmountInCents(null)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'with qtd wages equal start' => [
                $builder
                    ->setWagesInCents(100)
                    ->setQtdWageInCents(4999900)
                    ->setExpectedAmountInCents(null)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'with qtd wages over start' => [
                $builder
                    ->setWagesInCents(100)
                    ->setQtdWageInCents(4999999)
                    ->setExpectedAmountInCents(2)
                    ->setExpectedEarningsInCents(99)
                    ->build(),
            ],
            'wages under start' => [
                $builder
                    ->setWagesInCents(4999900)
                    ->setQtdWageInCents(0)
                    ->setExpectedAmountInCents(null)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'wages equal start' => [
                $builder
                    ->setWagesInCents(5000000)
                    ->setQtdWageInCents(0)
                    ->setExpectedAmountInCents(null)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'wages over start' => [
                $builder
                    ->setWagesInCents(5000100)
                    ->setQtdWageInCents(0)
                    ->setExpectedAmountInCents(2)
                    ->setExpectedEarningsInCents(100)
                    ->build(),
            ],
            'combined wages' => [
                $builder
                    ->setWagesInCents(3000000)
                    ->setQtdWageInCents(3000000)
                    ->setExpectedAmountInCents(14750)
                    ->setExpectedEarningsInCents(1000000)
                    ->build(),
            ],
        ];
    }
}
