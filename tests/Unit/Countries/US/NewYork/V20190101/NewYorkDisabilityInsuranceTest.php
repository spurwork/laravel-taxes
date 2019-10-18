<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewYork\V20190101;

use Appleton\Taxes\Countries\US\NewYork\NewYorkDisabilityInsurance\NewYorkDisabilityInsurance;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class NewYorkDisabilityInsuranceTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.new_york';
    private const TAX_CLASS = NewYorkDisabilityInsurance::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(IncomeParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function provideTestData(): array
    {
        $builder = new IncomeParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setWagesInCents(35000)
                    ->setExpectedAmountInCents(60)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setWagesInCents(140000)
                    ->setExpectedAmountInCents(60)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setExpectedAmountInCents(50)
                    ->build()
            ],
        ];
    }
}
