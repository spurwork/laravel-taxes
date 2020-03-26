<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Massachusetts\V20190101;

use Appleton\Taxes\Countries\US\Massachusetts\MassachusettsWorkforceTrainingFundEmployer\MassachusettsWorkforceTrainingFundEmployer;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\WageBaseTaxTestCase;

class MassachusettsWorkforceTrainingFundEmployerTest extends WageBaseTaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.massachusetts';
    private const TAX_CLASS = MassachusettsWorkforceTrainingFundEmployer::class;
    private const TAX_RATE = 0.00056;
    private const WAGE_BASE = 1500000;

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
