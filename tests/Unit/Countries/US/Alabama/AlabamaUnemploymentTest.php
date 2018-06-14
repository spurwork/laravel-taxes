<?php

namespace Appleton\Taxes\Countries\US\Alabama\AlabamaUnemployment;

use Appleton\Taxes\Countries\US\Alabama\AlabamaIncome;

class AlabamaUnemploymentTest extends \TestCase
{
    public function testAlabamaUnemployment()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(62.10, $results->getTax(AlabamaUnemployment::class));
    }

    public function testAlabamaUnemploymentWithTaxRate()
    {
        config(['taxes.rates.us.alabama.unemployment' => 0.024]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(55.20, $results->getTax(AlabamaUnemployment::class));
    }

    public function testAlabamaUnemploymentMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(7800);
        });

        $this->assertSame(2.70, $results->getTax(AlabamaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(7950);
        });

        $this->assertSame(1.35, $results->getTax(AlabamaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(8000);
        });

        $this->assertSame(0.0, $results->getTax(AlabamaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(8050);
        });

        $this->assertSame(0.0, $results->getTax(AlabamaUnemployment::class));
    }

    public function testCaseStudy1()
    {
        config(['taxes.rates.us.alabama.unemployment' => 0.019]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertSame(1.27, $results->getTax(AlabamaUnemployment::class));
    }

    public function testWorkOutOfState()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.alabama'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertNull($results->getTax(AlabamaIncome::class));
        $this->assertSame(62.10, $results->getTax(AlabamaUnemployment::class));
    }
}
