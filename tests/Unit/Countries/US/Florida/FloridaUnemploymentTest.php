<?php

namespace Appleton\Taxes\Countries\US\Florida\FloridaUnemployment;

use Appleton\Taxes\Countries\US\Florida\FloridaIncome;
use Carbon\Carbon;

class FloridaUnemploymentTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testFloridaUnemployment()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.florida'));
            $taxes->setWorkLocation($this->getLocation('us.florida'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(62.10, $results->getTax(FloridaUnemployment::class));
    }

    public function testFloridaUnemploymentWithTaxRate()
    {
        config(['taxes.rates.us.florida.unemployment' => 0.024]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.florida'));
            $taxes->setWorkLocation($this->getLocation('us.florida'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(55.20, $results->getTax(FloridaUnemployment::class));
    }

    public function testFloridaUnemploymentMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.florida'));
            $taxes->setWorkLocation($this->getLocation('us.florida'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(6900);
        });

        $this->assertSame(2.70, $results->getTax(FloridaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.florida'));
            $taxes->setWorkLocation($this->getLocation('us.florida'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(6950);
        });

        $this->assertSame(1.35, $results->getTax(FloridaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.florida'));
            $taxes->setWorkLocation($this->getLocation('us.florida'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(7000);
        });

        $this->assertSame(null, $results->getTax(FloridaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.florida'));
            $taxes->setWorkLocation($this->getLocation('us.florida'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(7050);
        });

        $this->assertSame(null, $results->getTax(FloridaUnemployment::class));
    }

    public function testCaseStudy1()
    {
        config(['taxes.rates.us.florida.unemployment' => 0.019]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.florida'));
            $taxes->setWorkLocation($this->getLocation('us.florida'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertSame(1.27, $results->getTax(FloridaUnemployment::class));
    }

    public function testWorkOutOfState()
    {
        config(['taxes.rates.us.florida.unemployment' => 0.019]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.florida'));
            $taxes->setWorkLocation($this->getLocation('us.tennessee'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertNull($results->getTax(FloridaIncome::class));
        $this->assertSame(1.27, $results->getTax(FloridaUnemployment::class));
    }
}
