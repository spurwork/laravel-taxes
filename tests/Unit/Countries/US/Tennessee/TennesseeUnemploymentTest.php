<?php

namespace Appleton\Taxes\Countries\US\Tennessee\TennesseeUnemployment;

use Carbon\Carbon;
use TestCase;

class TennesseeUnemploymentTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Carbon::setTestNow(Carbon::parse('2019-01-01'));
    }

    public function testTennesseeUnemploymentWithTaxRate()
    {
        config(['taxes.rates.us.tennessee.unemployment' => 0.024]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.tennessee'));
            $taxes->setWorkLocation($this->getLocation('us.tennessee'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(55.20, $results->getTax(TennesseeUnemployment::class));
    }

    public function testTennesseeUnemploymentUnderWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.tennessee'));
            $taxes->setWorkLocation($this->getLocation('us.tennessee'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(50);
            $taxes->setYtdEarnings(6900);
        });

        $this->assertSame(1.35, $results->getTax(TennesseeUnemployment::class));
    }

    public function testTennesseeUnemploymentMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.tennessee'));
            $taxes->setWorkLocation($this->getLocation('us.tennessee'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(50);
            $taxes->setYtdEarnings(6950);
        });

        $this->assertSame(1.35, $results->getTax(TennesseeUnemployment::class));
    }

    public function testTennesseeUnemploymentExceedWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.tennessee'));
            $taxes->setWorkLocation($this->getLocation('us.tennessee'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(1000);
            $taxes->setYtdEarnings(7000);
        });

        $this->assertSame(0.00, $results->getTax(TennesseeUnemployment::class));
    }

    public function testTennesseeUnemploymentWorkOutOfState()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.tennessee'));
            $taxes->setWorkLocation($this->getLocation('us.alabama'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(62.10, $results->getTax(TennesseeUnemployment::class));
    }
}
