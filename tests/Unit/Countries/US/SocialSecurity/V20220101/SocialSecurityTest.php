<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\SocialSecurity\V20220101;

use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\WageBaseTaxTestCase;

class SocialSecurityTest extends WageBaseTaxTestCase
{
    private const DATE = '2022-01-01';
    private const LOCATION = 'us';
    private const TAX_CLASS = SocialSecurity::class;
    private const WAGE_BASE_IN_CENTS = 14700000;
    private const TAX_RATE = 0.062;

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

    /**
     * @dataProvider provideWageBaseTestData
     */
    public function testWageBase(TestParameters $parameters): void
    {
        $this->validateWageBase($parameters);
    }

    public static function provideTestData(): array
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
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(3968)
                    ->setExpectedEarningsInCents(64000)
                    ->build()
            ],
            'case study B' => [
                $builder
                    ->setWagesInCents(77428)
                    ->setYtdLiabilitiesInCents(0)
                    ->setExpectedAmountInCents(4801)
                    ->setExpectedEarningsInCents(77428)
                    ->build()
            ],
            'case study C' => [
                $builder
                    ->setWagesInCents(64000)
                    ->setYtdLiabilitiesInCents(13300000)
                    ->setExpectedAmountInCents(3968)
                    ->setExpectedEarningsInCents(64000)
                    ->build()
            ],
            'case study D' => [
                $builder
                    ->setWagesInCents(77428)
                    ->setYtdLiabilitiesInCents(13300000)
                    ->setExpectedAmountInCents(4801)
                    ->setExpectedEarningsInCents(77428)
                    ->build()
            ],
        ];
    }

    public static function provideWageBaseTestData(): array
    {
        return self::wageBaseBoundariesTestCases(
            self::DATE,
            self::LOCATION,
            self::TAX_CLASS,
            self::WAGE_BASE_IN_CENTS,
            self::TAX_RATE
        );
    }
}
