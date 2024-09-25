<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Oregon\V20190701;

use Appleton\Taxes\Countries\US\Oregon\OregonTransit\OregonTransit;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class OregonTransitTaxTest extends TaxTestCase
{
    private const DATE = '2019-07-01';
    private const OREGON_LOCATION = 'us.oregon';
    private const ALABAMA_LOCATION = 'us.alabama';
    private const TAX_CLASS = OregonTransit::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
        $this->disableTestQueryRunner();
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    public function testNoTax(): void
    {
        $this->validateNoTax((new TestParametersBuilder())
            ->setDate(self::DATE)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(52)
            ->setHomeLocation(self::ALABAMA_LOCATION)
            ->setWorkLocation(self::ALABAMA_LOCATION)
            ->setWagesInCents(100000)
            ->build());
    }

    public static function provideTestData(): array
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
                    ->setWorkLocation(self::OREGON_LOCATION)
                    ->setWagesInCents(0)
                    ->setExpectedAmountInCents(0)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::OREGON_LOCATION)
                    ->setWorkLocation(self::OREGON_LOCATION)
                    ->setWagesInCents(40000)
                    ->setExpectedAmountInCents(40)
                    ->build()
            ],
            '02' => [
                $builder
                    ->setHomeLocation(self::ALABAMA_LOCATION)
                    ->setWorkLocation(self::OREGON_LOCATION)
                    ->setWagesInCents(93000)
                    ->setExpectedAmountInCents(93)
                    ->build()
            ],
            '03' => [
                $builder
                    ->setHomeLocation(self::OREGON_LOCATION)
                    ->setWorkLocation(self::ALABAMA_LOCATION)
                    ->setWagesInCents(93000)
                    ->setExpectedAmountInCents(93)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setHomeLocation(self::OREGON_LOCATION)
                    ->setWorkLocation(self::ALABAMA_LOCATION)
                    ->setWagesInCents(1900000)
                    ->setExpectedAmountInCents(1900)
                    ->build()
            ],
        ];
    }
}
