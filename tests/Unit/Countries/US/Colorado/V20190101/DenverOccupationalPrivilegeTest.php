<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Colorado\V20190101;

use Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilege\DenverOccupationalPrivilege;
use Appleton\Taxes\Tests\Unit\Countries\US\Colorado\ColoradoLocalIncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\US\Colorado\ColoradoLocalIncomeParametersBuilder;
use Appleton\Taxes\Tests\Unit\Countries\US\Colorado\ColoradoLocalTaxTestCase;

class DenverOccupationalPrivilegeTest extends ColoradoLocalTaxTestCase
{
    private const DATE = '2019-06-01';
    private const TAX_CLASS = DenverOccupationalPrivilege::class;
    private const LOCATION = 'us.colorado.denver';

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
                ->setLocalMtdLiabilitiesInCents(0)
                ->setColoradoEarningsInCents(100)
                ->setColoradoMtdLiabilitiesInCents(200)
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
            50000,
            575
        );
    }
}
