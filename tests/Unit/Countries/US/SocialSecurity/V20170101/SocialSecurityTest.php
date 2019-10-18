<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\SocialSecurity\V20170101;

use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity;
use Appleton\Taxes\Tests\Unit\Countries\WageBaseParameters;
use Appleton\Taxes\Tests\Unit\Countries\WageBaseTaxTestCase;

class SocialSecurityTest extends WageBaseTaxTestCase
{
    private const DATE = '2017-01-01';
    private const LOCATION = 'us.alabama';
    private const TAX_CLASS = SocialSecurity::class;
    private const WAGE_BASE_IN_CENTS = 12720000;
    private const TAX_RATE = 0.062;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /**
     * @dataProvider provideTestData
     */
    public function testTax(WageBaseParameters $parameters): void
    {
        $this->validateWageBase($parameters);
    }

    public function provideTestData(): array
    {
        return $this->wageBaseBoundariesTestCases(
            self::DATE,
            self::LOCATION,
            self::TAX_CLASS,
            self::WAGE_BASE_IN_CENTS,
            self::TAX_RATE
        );
    }
}
