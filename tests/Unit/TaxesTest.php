<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Classes\Taxes;
use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\AlabamaUnemployment;
use Appleton\Taxes\Countries\US\Alabama\BirminghamOccupational\BirminghamOccupational;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\FederalUnemployment\FederalUnemployment;
use Appleton\Taxes\Countries\US\Medicare\Medicare;
use Appleton\Taxes\Countries\US\Medicare\MedicareEmployer;
use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity;
use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurityEmployer;
use Appleton\Taxes\Models\Countries\US\Alabama\AlabamaIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;

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

        FederalIncomeTaxInformation::createForUser([
            'exemptions' => 0,
            'filing_status' => FederalIncome::FILING_SINGLE,
            'non_resident_alien' => false,
        ], $this->user);

        AlabamaIncomeTaxInformation::createForUser([
            'dependents' => 0,
            'filing_status' => AlabamaIncome::FILING_SINGLE,
        ], $this->user);
    }

    public function testTaxes()
    {
        $taxes = $this->app->make(Taxes::class);
        $this->assertSame(1, $this->user_model->count());

        $tax_results = $taxes->calculate(function ($taxes) {
            $taxes->setLocation(33.5207, -86.8025);
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(6.88, $tax_results->getTax(FederalIncome::class));
        $this->assertSame(0.4, $tax_results->getTax(FederalUnemployment::class));
        $this->assertSame(0.97, $tax_results->getTax(Medicare::class));
        $this->assertSame(0.97, $tax_results->getTax(MedicareEmployer::class));
        $this->assertSame(4.13, $tax_results->getTax(SocialSecurity::class));
        $this->assertSame(4.13, $tax_results->getTax(SocialSecurityEmployer::class));
        $this->assertSame(2.07, $tax_results->getTax(AlabamaIncome::class));
        $this->assertSame(1.27, $tax_results->getTax(AlabamaUnemployment::class));
        $this->assertSame(0.67, $tax_results->getTax(BirminghamOccupational::class));
    }
}
