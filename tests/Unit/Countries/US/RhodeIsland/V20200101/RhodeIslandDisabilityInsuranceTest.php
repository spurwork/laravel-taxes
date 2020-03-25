<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\RhodeIsland\V20200101;

use Appleton\Taxes\Countries\US\RhodeIsland\RhodeIslandDisabilityInsurance\RhodeIslandDisabilityInsurance;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class RhodeIslandDisabilityInsuranceTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.rhode_island';
    private const TAX_CLASS = RhodeIslandDisabilityInsurance::class;

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

    public function provideTestData(): array
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
