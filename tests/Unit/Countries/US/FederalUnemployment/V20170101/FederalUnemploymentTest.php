<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\FederalUnemployment\V20170101;

use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\AlabamaUnemployment;
use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\V20170101\AlabamaUnemployment as AlabamaUnemployment2017;
use Appleton\Taxes\Countries\US\FederalUnemployment\FederalUnemployment;
use Appleton\Taxes\Tests\Unit\Countries\TestParameters;
use Appleton\Taxes\Tests\Unit\Countries\WageBaseTaxTestCase;

class FederalUnemploymentTest extends WageBaseTaxTestCase
{
    private const DATE = '2017-01-01';
    private const LOCATION = 'us.alabama';
    private const TAX_CLASS = FederalUnemployment::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(AlabamaUnemployment::class);
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
            FederalUnemployment::class,
            700000,
            0.06 - AlabamaUnemployment2017::FUTA_CREDIT
        );
    }
}
