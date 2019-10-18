<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\WestVirginia\V20190101;

use Appleton\Taxes\Countries\US\WestVirginia\CharlestonCityServiceFee\CharlestonCityServiceFee;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class CharlestonCityServiceFeeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.west_virginia.charleston';
    private const TAX_CLASS = CharlestonCityServiceFee::class;

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
            'no wages' => [
                $builder
                    ->setWagesInCents(0)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            'wages' => [
                $builder
                    ->setWagesInCents(1)
                    ->setExpectedAmountInCents(300)
                    ->build()
            ],
        ];
    }
}
