<?php

namespace Appleton\Taxes\Countries\US\NewYork\NewYorkUnemployment;

use Carbon\Carbon;

class NewYorkUnemploymentTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testNewYorkUnemployment()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_york'));
            $taxes->setWorkLocation($this->getLocation('us.new_york'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(82.8, $results->getTax(NewYorkUnemployment::class));
    }

    public function testNewYorkUnemploymentWithTaxRate()
    {
        config(['taxes.rates.us.new_york.unemployment' => 0.024]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_york'));
            $taxes->setWorkLocation($this->getLocation('us.new_york'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(55.20, $results->getTax(NewYorkUnemployment::class));
    }

    public function testNewYorkUnemploymentMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_york'));
            $taxes->setWorkLocation($this->getLocation('us.new_york'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(11300);
        });

        $this->assertSame(3.6, $results->getTax(NewYorkUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_york'));
            $taxes->setWorkLocation($this->getLocation('us.new_york'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(11350);
        });

        $this->assertSame(1.8, $results->getTax(NewYorkUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_york'));
            $taxes->setWorkLocation($this->getLocation('us.new_york'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(11400);
        });

        $this->assertSame(0.0, $results->getTax(NewYorkUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_york'));
            $taxes->setWorkLocation($this->getLocation('us.new_york'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(11450);
        });

        $this->assertSame(0.0, $results->getTax(NewYorkUnemployment::class));
    }
}
