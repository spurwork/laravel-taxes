<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Delaware\V20200101;

use Appleton\Taxes\Countries\US\Delaware\DelawareEmployerTrainingTax\DelawareEmployerTrainingTax;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\WageBaseTaxTestCase;

class DelawareEmployerTrainingTaxTest extends WageBaseTaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.delaware';
    private const TAX_CLASS = DelawareEmployerTrainingTax::class;
    private const TAX_RATE = 0.00095;
    private const WAGE_BASE = 1650000;

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

    public function provideData(): array
    {
        return $this->wageBaseBoundariesTestCases(
            self::DATE,
            self::LOCATION,
            self::TAX_CLASS,
            self::WAGE_BASE,
            self::TAX_RATE
        );
    }
}
