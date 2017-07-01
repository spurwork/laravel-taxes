<?php

namespace Appleton\Taxes\Models;

use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

class TaxInformationTest extends \TestCase
{
    public function testTaxes()
    {
        $user = $this->user_model->forceCreate([
            'name' => 'Test User',
            'email' => 'test@user.email',
            'password' => 'password',
        ]);

        $federal_income_tax_information = FederalIncomeTaxInformation::create([
            'exemptions' => 1,
            'filing_status' => 0,
            'non_resident_alien' => true,
        ]);

        $tax_information = TaxInformation::create([]);
        $tax_information->information()->associate($federal_income_tax_information);
        $tax_information->user()->associate($user);
        $tax_information->save();
        $tax_information->fresh();

        $this->assertSame(1, $tax_information->information->exemptions);
        $this->assertSame(0, $tax_information->information->filing_status);
        $this->assertSame(true, $tax_information->information->non_resident_alien);
    }
}
