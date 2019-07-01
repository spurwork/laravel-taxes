<?php

namespace Appleton\Taxes\Countries\US\Massachusetts\MassachusettsUnemployment;

use Carbon\Carbon;

class MassachusettsUnemploymentTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testMassachusettsUnemployment()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(55.66, $results->getTax(MassachusettsUnemployment::class));
    }

    public function testMassachusettsUnemploymentWithTaxRate()
    {
        config(['taxes.rates.us.massachusetts.unemployment' => 0.024]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(55.20, $results->getTax(MassachusettsUnemployment::class));
    }

    public function testMassachusettsUnemploymentMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(14900);
        });

        $this->assertSame(2.42, $results->getTax(MassachusettsUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(14950);
        });

        $this->assertSame(1.21, $results->getTax(MassachusettsUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(15000);
        });

        $this->assertSame(null, $results->getTax(MassachusettsUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.massachusetts'));
            $taxes->setWorkLocation($this->getLocation('us.massachusetts'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(15050);
        });

        $this->assertSame(null, $results->getTax(MassachusettsUnemployment::class));
    }
}
