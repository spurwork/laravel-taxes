<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\WestVirginia\V20190101;

use Appleton\Taxes\Countries\US\WestVirginia\ParkersburgCityServiceFee\ParkersburgCityServiceFee;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class ParkersburgCityServiceFeeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.west_virginia.parkersburg';
    private const TAX_CLASS = ParkersburgCityServiceFee::class;

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
            'no wages' => [
                $builder
                    ->setWagesInCents(0)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            'wages' => [
                $builder
                    ->setWagesInCents(1)
                    ->setExpectedAmountInCents(250)
                    ->build()
            ],
        ];
    }
}
