<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20190101\local;

use Appleton\Taxes\Countries\US\Kentucky\KentonCounty\KentonCounty;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class KentonCountyTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.kentucky.kenton_county';
    private const TAX_CLASS = KentonCounty::class;

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
                    ->setWagesInCents(30000)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(213)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setWagesInCents(30000)
                    ->setYtdLiabilitiesInCents(2500000)
                    ->setExpectedAmountInCents(33)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setWagesInCents(90000)
                    ->setYtdLiabilitiesInCents(13290000)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
        ];
    }
}
