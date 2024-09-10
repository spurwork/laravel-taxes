<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\California\V20190101;

use Appleton\Taxes\Countries\US\California\SacramentoBusinessOperationsEmployer\SacramentoBusinessOperationsEmployer;
use Appleton\Taxes\Tests\Unit\Countries\PayrollLiabilityTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class SacramentoBusinessOperationsEmployerTest extends PayrollLiabilityTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.california.sacramento';
    private const TAX_CLASS = SacramentoBusinessOperationsEmployer::class;

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
            'no ytd wages' => [
                $builder
                    ->setWagesInCents(1000)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(3000)
                    ->setExpectedEarningsInCents(1000)
                    ->build(),
            ],
            'no wages' => [
                $builder
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(0)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'with ytd wages under start' => [
                $builder
                    ->setWagesInCents(100)
                    ->setYtdWagesInCents(999899)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'with ytd wages equal start' => [
                $builder
                    ->setWagesInCents(100)
                    ->setYtdWagesInCents(999900)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'with ytd wages over start' => [
                $builder
                    ->setWagesInCents(100)
                    ->setYtdWagesInCents(1000000)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(1)
                    ->setExpectedEarningsInCents(100)
                    ->build(),
            ],
            'wages under start' => [
                $builder
                    ->setWagesInCents(999800)
                    ->setYtdWagesInCents(100)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'wages equal start' => [
                $builder
                    ->setWagesInCents(999900)
                    ->setYtdWagesInCents(100)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'wages over start' => [
                $builder
                    ->setWagesInCents(1000000)
                    ->setYtdWagesInCents(100)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(1)
                    ->setExpectedEarningsInCents(100)
                    ->build(),
            ],
            'with ytd liabilities under max' => [
                $builder
                    ->setWagesInCents(100)
                    ->setYtdWagesInCents(1000000)
                    ->setYtdLiabilitiesInCents(499800)
                    ->setExpectedAmountInCents(1)
                    ->setExpectedEarningsInCents(100)
                    ->build(),
            ],
            'with ytd liabilities equal max' => [
                $builder
                    ->setWagesInCents(100)
                    ->setYtdWagesInCents(1000000)
                    ->setYtdLiabilitiesInCents(499900)
                    ->setExpectedAmountInCents(1)
                    ->setExpectedEarningsInCents(100)
                    ->build(),
            ],
            'with ytd liabilities over max' => [
                $builder
                    ->setWagesInCents(100)
                    ->setYtdWagesInCents(1000000)
                    ->setYtdLiabilitiesInCents(500000)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(null)
                    ->build(),
            ],
            'liabilities under max' => [
                $builder
                    ->setWagesInCents(1249996999)
                    ->setYtdWagesInCents(1000000)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(499999)
                    ->setExpectedEarningsInCents(1249996999)
                    ->build(),
            ],
            'liabilities equal max' => [
                $builder
                    ->setWagesInCents(1250000000)
                    ->setYtdWagesInCents(1000000)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(500000)
                    ->setExpectedEarningsInCents(1250000000)
                    ->build(),
            ],
            'liabilities over max' => [
                $builder
                    ->setWagesInCents(1250000100)
                    ->setYtdWagesInCents(1000000)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(500000)
                    ->setExpectedEarningsInCents(1250000000)
                    ->build(),
            ],
        ];
    }

}
