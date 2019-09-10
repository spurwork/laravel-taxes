<?php

namespace Appleton\Taxes\Countries\US\Georgia\GeorgiaUnemployment;

use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome;
use Carbon\Carbon;

class GeorgiaUnemploymentTest extends \TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testGeorgiaUnemployment()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(62.10, $results->getTax(GeorgiaUnemployment::class));
    }

    public function testGeorgiaUnemploymentWithTaxRate()
    {
        config(['taxes.rates.us.georgia.unemployment' => 0.024]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(55.20, $results->getTax(GeorgiaUnemployment::class));
    }

    public function testGeorgiaUnemploymentMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(9300);
        });

        $this->assertSame(2.70, $results->getTax(GeorgiaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(9450);
        });

        $this->assertSame(1.35, $results->getTax(GeorgiaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(9500);
        });

        $this->assertSame(null, $results->getTax(GeorgiaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(9550);
        });

        $this->assertSame(null, $results->getTax(GeorgiaUnemployment::class));
    }

    public function testCaseStudy1()
    {
        config(['taxes.rates.us.georgia.unemployment' => 0.019]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertSame(1.27, $results->getTax(GeorgiaUnemployment::class));
    }

    public function testWorkOutOfState()
    {
        config(['taxes.rates.us.georgia.unemployment' => 0.019]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.tennessee'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertNull($results->getTax(GeorgiaIncome::class));
        $this->assertSame(1.27, $results->getTax(GeorgiaUnemployment::class));
    }
}
