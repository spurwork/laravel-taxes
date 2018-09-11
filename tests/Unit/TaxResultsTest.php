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

class TaxResultsTest extends \TestCase
{
    public function testTaxes()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.birmingham'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.birmingham'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
            $taxes->setPayPeriods(260);
        });

        $this->assertEquals([
            FederalIncome::class => 6.88,
            FederalUnemployment::class => 0.4,
            Medicare::class => 0.97,
            MedicareEmployer::class => 0.97,
            SocialSecurity::class => 4.13,
            SocialSecurityEmployer::class => 4.13,
            AlabamaIncome::class => 2.06,
            AlabamaUnemployment::class => 1.8,
            BirminghamOccupational::class => 0.67,
        ], $results->getAllTaxes()->toArray());

        $this->assertEquals([
            FederalIncome::class => 6.88,
            Medicare::class => 0.97,
            SocialSecurity::class => 4.13,
            AlabamaIncome::class => 2.06,
            BirminghamOccupational::class => 0.67,
        ], $results->getEmployeeTaxes()->toArray());

        $this->assertEquals([
            FederalUnemployment::class => 0.4,
            MedicareEmployer::class => 0.97,
            SocialSecurityEmployer::class => 4.13,
            AlabamaUnemployment::class => 1.8,
        ], $results->getEmployerTaxes()->toArray());

        $this->assertEquals([
            FederalIncome::class => 6.88,
            FederalUnemployment::class => 0.4,
            Medicare::class => 0.97,
            MedicareEmployer::class => 0.97,
            SocialSecurity::class => 4.13,
            SocialSecurityEmployer::class => 4.13,
        ], $results->getFederalTaxes()->toArray());

        $this->assertEquals([
            AlabamaIncome::class => 2.06,
            AlabamaUnemployment::class => 1.8,
            BirminghamOccupational::class => 0.67,
        ], $results->getStateAndLocalTaxes()->toArray());

        $this->assertEquals(0.67, $results->getTax(BirminghamOccupational::class));
    }

    public function testAdjustedEarnings()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama.birmingham'));
            $taxes->setWorkLocation($this->getLocation('us.alabama.birmingham'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(10000);
            $taxes->setPayPeriods(260);
        });

        $this->assertEquals(10000, $results->getEarnings(FederalIncome::class));
        $this->assertEquals(7000, $results->getEarnings(FederalUnemployment::class));
        $this->assertEquals(8000, $results->getEarnings(AlabamaUnemployment::class));
    }
}
