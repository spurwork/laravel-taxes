<?php

namespace Appleton\Taxes\Tests\Unit\Countries\US\Colorado\V20190101;

use Appleton\Taxes\Countries\US\Colorado\AuroraOccupationalPrivilegeEmployer\AuroraOccupationalPrivilegeEmployer;
use Appleton\Taxes\Tests\Unit\Countries\US\Colorado\ColoradoLocalIncomeParameters;
use Appleton\Taxes\Tests\Unit\Countries\US\Colorado\ColoradoLocalTaxTestCase;

class AuroraOccupationalPrivilegeEmployerTest extends ColoradoLocalTaxTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->query_runner->addTax(AuroraOccupationalPrivilegeEmployer::class);
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
            'us.colorado.aurora',
            AuroraOccupationalPrivilegeEmployer::class,
            25000,
            200);
    }
}
