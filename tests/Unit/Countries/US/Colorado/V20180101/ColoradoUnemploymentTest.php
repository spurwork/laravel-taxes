<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Colorado\V20180101;

use Appleton\Taxes\Countries\US\Colorado\ColoradoUnemployment\ColoradoUnemployment;
use Appleton\Taxes\Tests\Unit\Countries\UnemploymentTaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;

class ColoradoUnemploymentTest extends UnemploymentTaxTestCase
{
    private const DATE = '2018-01-01';
    private const LOCATION = 'us.colorado';
    private const TAX_CLASS = ColoradoUnemployment::class;
    private const TAX_RATE = 0.017;
    private const WAGE_BASE = 1260000;

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

    public static function provideData(): array
    {
        return self::wageBaseBoundariesTestCases(
            self::DATE,
            self::LOCATION,
            self::TAX_CLASS,
            self::WAGE_BASE,
            self::TAX_RATE);
    }
}
