<?php

namespace Appleton\Taxes\Models;

use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

class TaxInformationTest extends \TestCase
{
    public function testCreateForUser()
    {
        $user = $this->user_model->forceCreate([
            'name' => 'Test User',
            'email' => 'test@user.email',
            'password' => 'password',
        ]);

        FederalIncomeTaxInformation::createForUser([
            'exemptions' => 1,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => true,
        ], $user);

        $federal_income_tax_information = TaxInformation::forUser($user)->isTypeOf(FederalIncomeTaxInformation::class)->first()->information;

        $this->assertSame(1, $federal_income_tax_information->exemptions);
        $this->assertSame(FederalIncome::FILING_SINGLE, $federal_income_tax_information->filing_status);
        $this->assertSame(true, $federal_income_tax_information->non_resident_alien);

        $federal_income_tax_information = FederalIncomeTaxInformation::forUser($user)->first();

        $this->assertSame(1, $federal_income_tax_information->exemptions);
        $this->assertSame(FederalIncome::FILING_SINGLE, $federal_income_tax_information->filing_status);
        $this->assertSame(true, $federal_income_tax_information->non_resident_alien);
    }
}
