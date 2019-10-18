<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\SouthCarolina\V20190101;

use Appleton\Taxes\Countries\US\SouthCarolina\SouthCarolinaIncome\SouthCarolinaIncome;
use Appleton\Taxes\Models\Countries\US\SouthCarolina\SouthCarolinaIncomeTaxInformation;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\IncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class SouthCarolinaIncomeTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.south_carolina';
    private const TAX_CLASS = SouthCarolinaIncome::class;
    private const TAX_INFO_CLASS = SouthCarolinaIncomeTaxInformation::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);

        SouthCarolinaIncomeTaxInformation::createForUser([
            'exemptions' => 0,
            'exempt' => false,
        ], $this->user);
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
            ->setTaxInfoClass(self::TAX_INFO_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setTaxInfoOptions(['exempt' => true])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(1351)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 1])
                    ->setWagesInCents(30000)
                    ->setExpectedAmountInCents(817)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 3])
                    ->setWagesInCents(55000)
                    ->setExpectedAmountInCents(1702)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setTaxInfoOptions(null)
                    ->setWagesInCents(15384)
                    ->setExpectedAmountInCents(444)
                    ->build()
            ],
            '05' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 2])
                    ->setWagesInCents(67307)
                    ->setExpectedAmountInCents(2819)
                    ->build()
            ],
            '06' => [
                $builder
                    ->setTaxInfoOptions(['exemptions' => 4])
                    ->setWagesInCents(100000)
                    ->setExpectedAmountInCents(4432)
                    ->build()
            ],
        ];
    }
}
