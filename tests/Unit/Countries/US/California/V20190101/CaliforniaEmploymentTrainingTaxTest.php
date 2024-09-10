<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\California\V20190101;

use Appleton\Taxes\Countries\US\California\CaliforniaEmploymentTrainingTax\CaliforniaEmploymentTrainingTax;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\WageBaseTaxTestCase;

class CaliforniaEmploymentTrainingTaxTest extends WageBaseTaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.california';
    private const TAX_CLASS = CaliforniaEmploymentTrainingTax::class;
    private const TAX_RATE = 0.001;
    private const WAGE_BASE = 700000;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /**
     * @dataProvider provideData
     */
    public function testTax(TestParameters $parameters): void
    {
        $this->validateWageBase($parameters);
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
