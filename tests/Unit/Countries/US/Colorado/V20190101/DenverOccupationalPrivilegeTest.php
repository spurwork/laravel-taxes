<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Colorado\V20190101;

use Appleton\Taxes\Countries\US\Colorado\DenverOccupationalPrivilege\DenverOccupationalPrivilege;
use Appleton\Taxes\Tests\Unit\Countries\US\Colorado\ColoradoLocalIncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\US\Colorado\ColoradoLocalTaxTestCase;

class DenverOccupationalPrivilegeTest extends ColoradoLocalTaxTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(DenverOccupationalPrivilege::class);
    }

    /**
     * @dataProvider provideData
     */
    public function testColoradoLocal(ColoradoLocalIncomeParameters $parameters): void
    {
        $this->validateColoradoLocal($parameters);
    }

    public function provideData(): array
    {
        $date = '2019-05-25';

        return $this->standardColoradoLocalTestCases(
            $date,
            'us.colorado.denver',
            DenverOccupationalPrivilege::class,
            50000,
            575);
    }
}
