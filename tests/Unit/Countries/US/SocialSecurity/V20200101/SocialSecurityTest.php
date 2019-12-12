<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\SocialSecurity\V20200101;

use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\TaxTestCase;

class SocialSecurityTest extends TaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us';
    private const TAX_CLASS = SocialSecurity::class;

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
            'case study A' => [
                $builder
                    ->setWagesInCents(64000)
                    ->setYtdWagesInCents(0)
                    ->setExpectedAmountInCents(3968)
                    ->setExpectedEarningsInCents(64000)
                    ->build()
            ],
            'case study B' => [
                $builder
                    ->setWagesInCents(77428)
                    ->setYtdWagesInCents(0)
                    ->setExpectedAmountInCents(4801)
                    ->setExpectedEarningsInCents(77428)
                    ->build()
            ],
            'case study C' => [
                $builder
                    ->setWagesInCents(64000)
                    ->setYtdWagesInCents(13300000)
                    ->setExpectedAmountInCents(3968)
                    ->setExpectedEarningsInCents(64000)
                    ->build()
            ],
            'case study D' => [
                $builder
                    ->setWagesInCents(77428)
                    ->setYtdWagesInCents(13300000)
                    ->setExpectedAmountInCents(4801)
                    ->setExpectedEarningsInCents(77428)
                    ->build()
            ],
            'under wage base' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setYtdWagesInCents(13769999)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(1)
                    ->build()
            ],
            'at wage base' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setYtdWagesInCents(13770000)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(0)
                    ->build()
            ],
            'over wage base' => [
                $builder
                    ->setWagesInCents(10000)
                    ->setYtdWagesInCents(13770001)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(0)
                    ->build()
            ],
        ];
    }
}
