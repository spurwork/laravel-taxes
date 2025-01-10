<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Connecticut\V20250101;

use Appleton\Taxes\Countries\US\Connecticut\ConnecticutUnemployment\ConnecticutUnemployment;
use Appleton\Taxes\Tests\Unit\Countries\UnemploymentTaxTestCase;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;

class ConnecticutUnemploymentTest extends UnemploymentTaxTestCase
{
    private const string DATE = '2025-01-01';
    private const string LOCATION = 'us.connecticut';
    private const string TAX_CLASS = ConnecticutUnemployment::class;
    private const float TAX_RATE = 0.034;
    private const int WAGE_BASE = 2610000;

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
