<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewHampshire\V20190101;

use Appleton\Taxes\Countries\US\NewHampshire\NewHampshireUnemployment\NewHampshireUnemployment;
use Appleton\Taxes\Tests\Unit\Countries\UnemploymentTaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;

class NewHampshireUnemploymentTest extends UnemploymentTaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.new_hampshire';
    private const TAX_CLASS = NewHampshireUnemployment::class;
    private const TAX_RATE = 0.012;
    private const WAGE_BASE = 1400000;

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
        $this->validateWorkDifferentState(
            self::DATE,
            self::LOCATION,
            self::TAX_CLASS,
            self::TAX_RATE
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

    public function provideData(): array
    {
        return $this->wageBaseBoundariesTestCases(
            self::DATE,
            self::LOCATION,
            self::TAX_CLASS,
            self::WAGE_BASE,
            self::TAX_RATE);
    }
}
