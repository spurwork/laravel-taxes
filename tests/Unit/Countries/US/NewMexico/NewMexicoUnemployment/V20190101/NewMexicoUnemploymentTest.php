<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoUnemployment\V20180101;

use Appleton\Taxes\Countries\US\NewMexico\NewMexicoUnemployment\NewMexicoUnemployment as ParentNewMexicoUnemployment;
use Carbon\Carbon;

class NewMexicoUnemploymentTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
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
            $taxes->setYtdEarnings(24700);
        });

        $this->assertSame(1.00, $results->getTax(ParentNewMexicoUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(24750);
        });

        $this->assertSame(0.5, $results->getTax(ParentNewMexicoUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(24800);
        });

        $this->assertSame(0.0, $results->getTax(ParentNewMexicoUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(24850);
        });

        $this->assertSame(0.0, $results->getTax(ParentNewMexicoUnemployment::class));
    }
}
