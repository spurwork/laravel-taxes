<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Nevada\V20190101;

use Appleton\Taxes\Countries\US\Nevada\NevadaUnemployment\NevadaUnemployment;
use Appleton\Taxes\Tests\Unit\Countries\UnemploymentTaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;

class NevadaUnemploymentTest extends UnemploymentTaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.nevada';
    private const TAX_CLASS = NevadaUnemployment::class;
    private const TAX_RATE = 0.03;
    private const WAGE_BASE = 3120000;

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
