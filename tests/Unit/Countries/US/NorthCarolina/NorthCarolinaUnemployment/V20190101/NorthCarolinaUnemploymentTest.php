<?php

namespace Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaUnemployment\V20190101;

use Carbon\Carbon;
use Appleton\Taxes\Countries\US\NorthCarolina\NorthCarolinaUnemployment\NorthCarolinaUnemployment as ParentNorthCarolinaUnemployment;


class NorthCarolinaUnemploymentTest extends \TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testNorthCarolinaUnemployment()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(ParentNorthCarolinaUnemployment::class));
    }

    public function testNorthCarolinaUnemploymentWithTaxRate()
    {
        config(['taxes.rates.us.north_carolina.unemployment' => 0.024]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(55.20, $results->getTax(ParentNorthCarolinaUnemployment::class));
    }

    public function testNorthCarolinaUnemploymentMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(24200);
        });

        $this->assertSame(1.00, $results->getTax(ParentNorthCarolinaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(24250);
        });

        $this->assertSame(0.50, $results->getTax(ParentNorthCarolinaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(24300);
        });

        $this->assertSame(null, $results->getTax(ParentNorthCarolinaUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(24350);
        });

        $this->assertSame(null, $results->getTax(ParentNorthCarolinaUnemployment::class));
    }

    public function testCaseStudy1()
    {
        config(['taxes.rates.us.north_carolina.unemployment' => 0.019]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us.north_carolina'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertSame(1.27, $results->getTax(ParentNorthCarolinaUnemployment::class));
    }

    public function testWorkOutOfState()
    {
        config(['taxes.rates.us.north_carolina.unemployment' => 0.019]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.north_carolina'));
            $taxes->setWorkLocation($this->getLocation('us'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(66.68);
        });

        $this->assertNull($results->getTax(NorthCarolinaIncome::class));
        $this->assertSame(1.27, $results->getTax(ParentNorthCarolinaUnemployment::class));
    }
}
