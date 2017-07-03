<?php

namespace Appleton\Taxes\Models;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

class TaxInformationTest extends \TestCase
{
    public function testCreateForUser()
    {
        $federal_income_tax_information = TaxInformation::forUser($this->user)->isTypeOf(FederalIncomeTaxInformation::class)->first()->information;

        $this->assertSame(0, $federal_income_tax_information->exemptions);
        $this->assertSame(Taxes::resolve(FederalIncome::class)::FILING_SINGLE, $federal_income_tax_information->filing_status);
        $this->assertSame(false, $federal_income_tax_information->non_resident_alien);

        $federal_income_tax_information = FederalIncomeTaxInformation::forUser($this->user)->first();

        $this->assertSame(0, $federal_income_tax_information->exemptions);
        $this->assertSame(Taxes::resolve(FederalIncome::class)::FILING_SINGLE, $federal_income_tax_information->filing_status);
        $this->assertSame(false, $federal_income_tax_information->non_resident_alien);
    }
}
