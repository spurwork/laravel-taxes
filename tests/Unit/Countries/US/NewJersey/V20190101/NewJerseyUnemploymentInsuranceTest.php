<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewJersey\V20190101;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyUnemploymentInsurance\NewJerseyUnemploymentInsurance;
use Appleton\Taxes\Tests\Unit\Countries\WageBaseParameters;
use Appleton\Taxes\Tests\Unit\Countries\WageBaseTaxTestCase;

class NewJerseyUnemploymentInsuranceTest extends WageBaseTaxTestCase
{
    private const DATE = '2019-01-01';
    private const LOCATION = 'us.new_jersey';
    private const TAX_CLASS = NewJerseyUnemploymentInsurance::class;
    private const TAX_RATE = 0.00425;
    private const WAGE_BASE = 3440000;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /**
     * @dataProvider provideData
     */
    public function testWageBase(WageBaseParameters $parameters): void
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
            self::TAX_RATE);
    }

}
