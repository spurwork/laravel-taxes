<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Colorado\V20190101;

use Appleton\Taxes\Countries\US\Colorado\GreenwoodVillageOccupationalPrivilege\GreenwoodVillageOccupationalPrivilege;
use Appleton\Taxes\Tests\Unit\Countries\US\Colorado\ColoradoLocalIncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\US\Colorado\ColoradoLocalIncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\US\Colorado\ColoradoLocalTaxTestCase;

class GreenwoodVillageOccupationalPrivilegeTest extends ColoradoLocalTaxTestCase
{
    private const DATE = '2019-05-25';
    private const TAX_CLASS = GreenwoodVillageOccupationalPrivilege::class;
    private const LOCATION = 'us.colorado.greenwood_village';

    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(self::TAX_CLASS);
    }

    /**
     * @dataProvider provideData
     */
    public function testColoradoLocal(ColoradoLocalIncomeParameters $parameters): void
    {
        $this->validateColoradoLocal($parameters);
    }

    public function testColoradoLocal_no_local_wages()
    {
        $this->validateColoradoLocalNoTax(
            (new ColoradoLocalIncomeParametersBuilder())
                ->setDate(self::DATE)
                ->setLocalLocation(self::LOCATION)
                ->setTaxClass(self::TAX_CLASS)
                ->setLocalEarningsInCents(0)
                ->setLocalMtdEarningsInCents(0)
                ->setColoradoEarningsInCents(100)
                ->setColoradoMtdEarningsInCents(200)
                ->setExpectedAmountInCents(0)
                ->build()
        );
    }

    public function provideData(): array
    {
        return $this->standardColoradoLocalTestCases(
            self::DATE,
            self::LOCATION,
            self::TAX_CLASS,
            25000,
            200);
    }
}
