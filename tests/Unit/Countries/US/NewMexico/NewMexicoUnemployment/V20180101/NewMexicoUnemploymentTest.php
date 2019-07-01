<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoUnemployment\V20180101;

use Appleton\Taxes\Countries\US\NewMexico\NewMexicoUnemployment\NewMexicoUnemployment as ParentNewMexicoUnemployment;
use Carbon\Carbon;
use DB;

class NewMexicoUnemploymentTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testNewMexicoUnemployment()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(23.00, $results->getTax(ParentNewMexicoUnemployment::class));
    }

    public function testNewMexicoUnemploymentWithTaxRate()
    {
        config(['taxes.rates.us.new_mexico.unemployment' => 0.024]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(55.20, $results->getTax(ParentNewMexicoUnemployment::class));
    }

    public function testNewMexicoUnemploymentMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(24100);
        });

        $this->assertSame(1.00, $results->getTax(ParentNewMexicoUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(24150);
        });

        $this->assertSame(0.5, $results->getTax(ParentNewMexicoUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(24200);
        });

        $this->assertSame(null, $results->getTax(ParentNewMexicoUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(24250);
        });

        $this->assertSame(null, $results->getTax(ParentNewMexicoUnemployment::class));
    }
}
