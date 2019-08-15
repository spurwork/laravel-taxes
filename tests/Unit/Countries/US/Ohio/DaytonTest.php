<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Classes\TaxResults;
use Appleton\Taxes\Countries\US\Ohio\Cleveland\Cleveland;
use Appleton\Taxes\Countries\US\Ohio\Dayton\Dayton;
use Carbon\Carbon;
use TestCase;

class DaytonTest extends TestCase
{
    public function testDayton_over_18()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(Carbon::now()->subYears(19));
        $this->assertSame(7.50, $results->getTax(Dayton::class));
    }

    public function testDayton_18()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(Carbon::now()->subYears(18));
        $this->assertSame(7.50, $results->getTax(Dayton::class));
    }

    public function testDayton_under_18()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(Carbon::now()->subYears(17));
        $this->assertNull($results->getTax(Dayton::class));
    }

    private function calculateTaxes(Carbon $birth_date): TaxResults
    {
        return $this->taxes->calculate(function ($taxes) use ($birth_date) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.dayton'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.dayton'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setBirthDate($birth_date);
        });
    }
}
