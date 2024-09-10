<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\SocialSecurity\V20180101;

use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurityEmployer;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\WageBaseTaxTestCase;

class SocialSecurityEmployerTest extends WageBaseTaxTestCase
{
    private const DATE = '2018-01-01';
    private const LOCATION = 'us.alabama';
    private const TAX_CLASS = SocialSecurityEmployer::class;
    private const TAX_RATE = 0.062;
    private const WAGE_BASE = 12840000;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /**
     * @dataProvider provideData
     */
    public function testCases(TestParameters $parameters): void
    {
        $this->validate($parameters);
    }

    /**
     * @dataProvider provideWageBaseData
     */
    public function testWageBase(TestParameters $parameters): void
    {
        $this->validateWageBase($parameters);
    }

    public static function provideData(): array
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
                    ->setYtdLiabilitiesInCents(12850000)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(0)
                    ->build()
            ],
            'case study D' => [
                $builder
                    ->setWagesInCents(77428)
                    ->setYtdLiabilitiesInCents(12850000)
                    ->setExpectedAmountInCents(0)
                    ->setExpectedEarningsInCents(0)
                    ->build()
            ],
        ];
    }

    public static function provideWageBaseData(): array
    {
        return self::wageBaseBoundariesTestCases(
            self::DATE,
            self::LOCATION,
            self::TAX_CLASS,
            self::WAGE_BASE,
            self::TAX_RATE
        );
    }
}
