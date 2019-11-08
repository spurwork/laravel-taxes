<?php

namespace Appleton\Taxes\Countries\US\Oregon\V20190101;

use Appleton\Taxes\Countries\US\Oregon\Eugene\Eugene;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;

class EugeneTest extends TaxTestCase
{
    private const DATE = '2019-01-01';
    private const EUGENE_LOCATION = 'us.oregon.eugene';
    private const OREGON_LOCATION = 'us.oregon';
    private const ALABAMA_LOCATION = 'us.alabama';
    private const TAX_CLASS = Eugene::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
        $this->disableTestQueryRunner();
    }

    /**
     * @dataProvider provideTestData
     */
    public function testEugeneTax(TestParameters $parameters): void
    {
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
                    ->setWagesInCents(35000)
                    ->setPayRate(1125)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
            '01' => [
                $builder
                    ->setHomeLocation(self::OREGON_LOCATION)
                    ->setWorkLocation(self::EUGENE_LOCATION)
                    ->setWagesInCents(35000)
                    ->setPayRate(1200)
                    ->setExpectedAmountInCents(105)
                    ->build()
            ],
            // '02' => [
            //     $builder
            //         ->setHomeLocation(self::EUGENE_LOCATION)
            //         ->setWorkLocation(self::ALABAMA_LOCATION)
            //         ->setWagesInCents(35000)
            //         ->setPayRate(1200)
            //         ->setExpectedAmountInCents(null)
            //         ->build()
            // ],
            '03' => [
                $builder
                    ->setHomeLocation(self::OREGON_LOCATION)
                    ->setWorkLocation(self::EUGENE_LOCATION)
                    ->setWagesInCents(35000)
                    ->setPayRate(1600)
                    ->setExpectedAmountInCents(154)
                    ->build()
            ],
            '04' => [
                $builder
                    ->setHomeLocation(self::EUGENE_LOCATION)
                    ->setWorkLocation(self::OREGON_LOCATION)
                    ->setWagesInCents(35000)
                    ->setPayRate(1600)
                    ->setExpectedAmountInCents(null)
                    ->build()
            ],
        ];
    }

    //         '4' => [
    //             'January 1, 2019 8am',
    //             1200,
    //             350,
    //             'us.oregon.eugene',
    //             'us.oregon',
    //             null,
    //         ],
    //         '5' => [
    //             'January 1, 2019 8am',
    //             1600,
    //             350,
    //             'us.oregon',
    //             'us.oregon.eugene',
    //             1.54,
    //         ],
    //         '6' => [
    //             'January 1, 2019 8am',
    //             1600,
    //             350,
    //             'us.oregon.eugene',
    //             'us.oregon',
    //             null,
    //         ],
    //     ];
    // }
}
