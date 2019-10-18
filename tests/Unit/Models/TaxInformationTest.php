<?php

namespace Appleton\Taxes\Tests\Unit\Models;

use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Models\TaxInformation;
use Appleton\Taxes\Tests\Unit\UnitTestCase;

class TaxInformationTest extends UnitTestCase
{
    public function testCreateForUser()
    {
        FederalIncomeTaxInformation::createForUser([
            'additional_withholding' => 0,
            'exemptions' => 0,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => false,
        ], $this->user);

        $federal_income_tax_information = TaxInformation::forUser($this->user)->isTypeOf(FederalIncomeTaxInformation::class)->first()->information;

        $this->assertSame(0, $federal_income_tax_information->exemptions);
        $this->assertSame(FederalIncome::FILING_SINGLE, $federal_income_tax_information->filing_status);
        $this->assertSame(false, $federal_income_tax_information->non_resident_alien);
        $this->assertSame(FederalIncome::class, $federal_income_tax_information->getTax());
        $this->assertSame('FILING_SINGLE', $federal_income_tax_information->getTax()::FILING_STATUSES[FederalIncome::FILING_SINGLE]);

        $federal_income_tax_information = FederalIncomeTaxInformation::forUser($this->user)->first();

        $this->assertSame(0, $federal_income_tax_information->exemptions);
        $this->assertSame(FederalIncome::FILING_SINGLE, $federal_income_tax_information->filing_status);
        $this->assertSame(false, $federal_income_tax_information->non_resident_alien);
        $this->assertSame(FederalIncome::class, $federal_income_tax_information->getTax());
        $this->assertSame('FILING_SINGLE', $federal_income_tax_information->getTax()::FILING_STATUSES[FederalIncome::FILING_SINGLE]);
    }
}
