<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\ClintonCity\ClintonCity;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class ClintonCityTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.kentucky.clinton_city';
    private const TAX_CLASS = ClintonCity::class;

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
                    ->setWagesInCents(0)
                    ->setYtdWagesInCents(0)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setWagesInCents(30000)
                    ->setYtdWagesInCents(500000)
                    ->setExpectedAmountInCents(150)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setWagesInCents(90000)
                    ->setYtdWagesInCents(3910000)
                    ->setExpectedAmountInCents(450)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setWagesInCents(77100)
                    ->setYtdWagesInCents(4000000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
        ];
    }
}
