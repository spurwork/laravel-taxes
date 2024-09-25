<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\NewJersey\V20200101;

use Appleton\Taxes\Countries\US\NewJersey\NewJerseyDisabilityInsurance\NewJerseyDisabilityInsurance;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\WageBaseTaxTestCase;

class NewJerseyDisabilityInsuranceTest extends WageBaseTaxTestCase
{
    private const DATE = '2020-01-01';
    private const LOCATION = 'us.new_jersey';
    private const TAX_CLASS = NewJerseyDisabilityInsurance::class;
    private const TAX_RATE = 0.0026;
    private const WAGE_BASE = 13490000;

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

    public static function provideData(): array
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
