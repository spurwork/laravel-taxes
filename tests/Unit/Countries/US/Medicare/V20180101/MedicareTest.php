<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Medicare\V20180101;

use Appleton\Taxes\Countries\US\Medicare\Medicare;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class MedicareTest extends TaxTestCase
{
    private const DATE = '2018-01-01';
    private const LOCATION = 'us.alabama';
    private const TAX_CLASS = Medicare::class;

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

    public static function provideTestData(): array
    {
        $builder = new TestParametersBuilder();
        $builder
            ->setDate(self::DATE)
            ->setHomeLocation(self::LOCATION)
            ->setTaxClass(self::TAX_CLASS)
            ->setPayPeriods(1);

        return [
            'case study A' => [
                $builder
                    ->setWagesInCents(27167)
                    ->setYtdLiabilitiesInCents(2489733)
                    ->setExpectedAmountInCents(394)
                    ->build()
            ],
            'case study B' => [
                $builder
                    ->setWagesInCents(76512)
                    ->setYtdLiabilitiesInCents(20010000)
                    ->setExpectedAmountInCents(1798)
                    ->build()
            ],
        ];
    }
}
