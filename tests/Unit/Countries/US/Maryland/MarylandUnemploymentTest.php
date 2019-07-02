<?php

namespace Appleton\Taxes\Unit\Countries\US\Maryland;

use Appleton\Taxes\Countries\US\Maryland\MarylandUnemployment\MarylandUnemployment;
use Carbon\Carbon;
use TestCase;

class MarylandUnemploymentTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testMarylandUnemployment()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.maryland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(2300 * 0.026, $results->getTax(MarylandUnemployment::class));
    }

    public function testMarylandUnemploymentWithTaxRate()
    {
        config(['taxes.rates.us.maryland.unemployment' => 0.024]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.maryland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(2300);
        });

        $this->assertSame(2300 * 0.024, $results->getTax(MarylandUnemployment::class));
    }

    public function testMarylandUnemploymentMetWageBase()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.maryland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(8400);
        });

        $this->assertSame(100 * 0.026, $results->getTax(MarylandUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.maryland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(8450);
        });

        $this->assertSame(50 * 0.026, $results->getTax(MarylandUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.maryland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(8500);
        });

        $this->assertSame(null, $results->getTax(MarylandUnemployment::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.maryland'));
            $taxes->setWorkLocation($this->getLocation('us.maryland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setYtdEarnings(8501);
        });

        $this->assertSame(null, $results->getTax(MarylandUnemployment::class));
    }
}