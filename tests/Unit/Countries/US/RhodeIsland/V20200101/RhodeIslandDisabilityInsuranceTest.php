<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\RhodeIsland\V20200101;

use Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandDisabilityInsurance\RhodeIslandDisabilityInsurance;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\WageBaseTaxTestCase;

class RhodeIslandDisabilityInsuranceTest extends WageBaseTaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.rhode_island';
    private const TAX_CLASS = RhodeIslandDisabilityInsurance::class;
    private const TAX_RATE = 0.013;
    private const WAGE_BASE = 7230000;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    /**
     * @dataProvider provideWageBaseData
     */
    public function testWageBase(TestParameters $parameters): void
    {
        $this->validateWageBase($parameters);
    }

    public static function provideWageBaseData(): array
    {
        return self::wageBaseBoundariesTestCases(
            self::DATE,
            self::LOCATION,
            self::TAX_CLASS,
            self::WAGE_BASE,
            self::TAX_RATE
        );
    }

    public static function provideTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setWagesInCents(35000)
                    ->setExpectedAmountInCents(455)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setWagesInCents(140000)
                    ->setExpectedAmountInCents(1820)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setExpectedAmountInCents(130)
                    ->build()
            ],
        ];
    }
}
