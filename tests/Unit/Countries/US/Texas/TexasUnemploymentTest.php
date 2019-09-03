<?php

namespace Appleton\Taxes\Countries\US\Texas\TexasUnemployment;

use Appleton\Taxes\Countries\US\Texas\TexasIncome;
use Carbon\Carbon;

class TexasUnemploymentTest extends \TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testTexasUnemployment()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.texas'));
            $taxes->setWorkLocation($this->getLocation('us.texas'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(62.10, $results->getTax(TexasUnemployment::class));
    }

    public function testTexasUnemploymentWithTaxRate()
    {
        config(['taxes.rates.us.texas.unemployment' => 0.024]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.texas'));
            $taxes->setWorkLocation($this->getLocation('us.texas'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(55.20, $results->getTax(TexasUnemployment::class));
    }

    public function testTexasUnemploymentMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.texas'));
            $taxes->setWorkLocation($this->getLocation('us.texas'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(8900);
        });

        $this->assertSame(2.70, $results->getTax(TexasUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.texas'));
            $taxes->setWorkLocation($this->getLocation('us.texas'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(8950);
        });

        $this->assertSame(1.35, $results->getTax(TexasUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.texas'));
            $taxes->setWorkLocation($this->getLocation('us.texas'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(9000);
        });

        $this->assertSame(null, $results->getTax(TexasUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.texas'));
            $taxes->setWorkLocation($this->getLocation('us.texas'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(9050);
        });

        $this->assertSame(null, $results->getTax(TexasUnemployment::class));
    }

    public function testCaseStudy1()
    {
        config(['taxes.rates.us.texas.unemployment' => 0.019]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.texas'));
            $taxes->setWorkLocation($this->getLocation('us.texas'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertSame(1.27, $results->getTax(TexasUnemployment::class));
    }

    public function testWorkOutOfState()
    {
        config(['taxes.rates.us.texas.unemployment' => 0.019]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.texas'));
            $taxes->setWorkLocation($this->getLocation('us.tennessee'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertNull($results->getTax(TexasIncome::class));
        $this->assertSame(1.27, $results->getTax(TexasUnemployment::class));
    }
}
