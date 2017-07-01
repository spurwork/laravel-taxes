<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\FederalIncome;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;

class TaxesTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->user = $this->user_model->forceCreate([
            'name' => 'Test User',
            'email' => 'test@user.email',
            'password' => 'password',
        ]);
    }

    public function testTaxes()
    {
        $taxes = $this->app->make(Taxes::class);

        $taxes->addTaxInformationToUser(FederalIncomeTaxInformation::class, [
            'exemptions' => 0,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => false,
        ], $this->user);

        $taxes->addTaxInformationToUser(AlabamaIncomeTaxInformation::class, [
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_SINGLE,
        ], $this->user);

    }
}
