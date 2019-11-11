<?php

namespace Appleton\Taxes\Countries\US\Oregon\V20190101;

use Appleton\Taxes\Countries\US\Oregon\Eugene\Eugene;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class EugeneTest extends TaxTestCase
{
    private const DATE = '2019-07-09';
    private const EUGENE_LOCATION = 'us.oregon.eugene';
    private const OREGON_LOCATION = 'us.oregon';
    private const ALABAMA_LOCATION = 'us.alabama';
    private const TAX_CLASS = Eugene::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testEugeneTax(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    /**
     * @dataProvider provideTestDataOutOfArea
     */

    public function testEugeneTaxOutOfArea(TestParameters $parameters): void
    {
        $this->disableTestQueryRunner();
        $this->validate($parameters);
    }

    public function provideTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setHomeLocation(self::OREGON_LOCATION)
                    ->setWorkLocation(self::EUGENE_LOCATION)
                    ->setWagesInCents(1125)
                    ->setMinutesWorked(60)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::OREGON_LOCATION)
                    ->setWorkLocation(self::EUGENE_LOCATION)
                    ->setWagesInCents(1200)
                    ->setMinutesWorked(60)
                    // need to delete this line and uncomment
                    // the null line after Tasie tests
                    ->setExpectedAmountInCents(4)

                    // ->setExpectedAmountInCents(null)

                    ->build()
            ],
            '02' => [
                $builder
                    ->setHomeLocation(self::OREGON_LOCATION)
                    ->setWorkLocation(self::EUGENE_LOCATION)
                    ->setWagesInCents(1600)
                    ->setMinutesWorked(60)
                    // need to delete this line and uncomment
                    // the null line after Tasie tests
                    ->setExpectedAmountInCents(7)

                    // ->setExpectedAmountInCents(null)

                    ->build()
            ],
        ];
    }

    public function provideTestDataOutOfArea(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(52);

        return [
            '00' => [
                $builder
                    ->setHomeLocation(self::EUGENE_LOCATION)
                    ->setWorkLocation(self::ALABAMA_LOCATION)
                    ->setWagesInCents(1200)
                    ->setMinutesWorked(60)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::EUGENE_LOCATION)
                    ->setWorkLocation(self::OREGON_LOCATION)
                    ->setWagesInCents(1600)
                    ->setMinutesWorked(60)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
        ];
    }
}
