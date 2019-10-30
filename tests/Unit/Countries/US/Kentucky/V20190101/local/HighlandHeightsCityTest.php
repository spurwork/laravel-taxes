<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Kentucky\V20190101;

use Appleton\Taxes\Countries\US\Kentucky\HighlandHeightsCity\HighlandHeightsCity;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class HighlandHeightsCityTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.kentucky.highland_heights_city';
    private const TAX_CLASS = HighlandHeightsCity::class;

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
                    ->setExpectedAmountInCents(300)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setWagesInCents(90000)
                    ->setYtdWagesInCents(9910000)
                    ->setExpectedAmountInCents(900)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setWagesInCents(77100)
                    ->setYtdWagesInCents(10000000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
        ];
    }
}
