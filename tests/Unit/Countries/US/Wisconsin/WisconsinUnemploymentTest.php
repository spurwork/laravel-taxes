<?php

namespace Appleton\Taxes\Countries\US\Wisconsin\WisconsinUnemployment;

use Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome\WisconsinIncome;
use Carbon\Carbon;

class WisconsinUnemploymentTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testWisconsinUnemployment()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wisconsin'));
            $taxes->setWorkLocation($this->getLocation('us.wisconsin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(70.15, $results->getTax(WisconsinUnemployment::class));
    }

    public function testWisconsinUnemploymentWithTaxRate()
    {
        config(['taxes.rates.us.wisconsin.unemployment' => 0.024]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wisconsin'));
            $taxes->setWorkLocation($this->getLocation('us.wisconsin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(55.20, $results->getTax(WisconsinUnemployment::class));
    }

    public function testWisconsinUnemploymentMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wisconsin'));
            $taxes->setWorkLocation($this->getLocation('us.wisconsin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(13800);
        });

        $this->assertSame(3.05, $results->getTax(WisconsinUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wisconsin'));
            $taxes->setWorkLocation($this->getLocation('us.wisconsin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(13950);
        });

        $this->assertSame(1.53, $results->getTax(WisconsinUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wisconsin'));
            $taxes->setWorkLocation($this->getLocation('us.wisconsin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(14000);
        });

        $this->assertSame(0.0, $results->getTax(WisconsinUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wisconsin'));
            $taxes->setWorkLocation($this->getLocation('us.wisconsin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(14050);
        });

        $this->assertSame(0.0, $results->getTax(WisconsinUnemployment::class));
    }
}
