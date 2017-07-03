<?php

namespace Appleton\Taxes\Classes;

use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome\AlabamaIncome;
use Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment\AlabamaUnemployment;
use Appleton\Taxes\Countries\US\Alabama\BirminghamOccupational\BirminghamOccupational;
use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Countries\US\FederalUnemployment\FederalUnemployment;
use Appleton\Taxes\Countries\US\Medicare\Medicare;
use Appleton\Taxes\Countries\US\Medicare\MedicareEmployer;
use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurity;
use Appleton\Taxes\Countries\US\SocialSecurity\SocialSecurityEmployer;

class TaxesTest extends \TestCase
{
    public function testTaxes()
    {
        $tax_results = $this->taxes->calculate(function ($taxes) {
            $taxes->setWorkLocation(33.5207, -86.8025);
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
