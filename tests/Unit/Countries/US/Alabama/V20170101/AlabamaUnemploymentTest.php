<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Alabama\V20170101;

use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\AlabamaUnemployment;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\TestParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\UnemploymentTaxTestCase;

class AlabamaUnemploymentTest extends UnemploymentTaxTestCase
{
    private const DATE = '2017-01-01';
    private const LOCATION = 'us.alabama';
    private const TAX_CLASS = AlabamaUnemployment::class;
    private const TAX_RATE = 0.027;
    private const WAGE_BASE = 800000;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /**
     * @dataProvider provideData
     */
    public function testWageBase(TestParameters $parameters): void
    {
        $this->validateWageBase($parameters);
    }

    public function testWorkDifferentState(): void
    {
        $this->validateWageBase(
            (new TestParametersBuilder())
                ->setDate(self::DATE)
                ->setHomeLocation(self::LOCATION)
                ->setWorkLocation('us.georgia')
                ->setTaxClass(self::TAX_CLASS)
                ->setWagesInCents(1000)
                ->setYtdWagesInCents(null)
                ->setExpectedAmountInCents(round(1000 * self::TAX_RATE))
                ->setExpectedEarningsInCents(round(1000))
                ->addSutaRate('AL', .027)
                ->build()
        );
    }

    public function testTaxRate(): void
    {
        $this->validateTaxRate(
            self::DATE,
            self::LOCATION,
            self::TAX_CLASS,
            0.0321
        );
    }

    public static function provideData(): array
    {
        return self::wageBaseBoundariesTestCases(
            self::DATE,
            self::LOCATION,
            self::TAX_CLASS,
            self::WAGE_BASE,
            self::TAX_RATE,
        );
    }
}
