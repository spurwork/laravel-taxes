<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Classes\TaxResults;
use Appleton\Taxes\Countries\US\Ohio\Cincinnati\Cincinnati;
use Appleton\Taxes\Countries\US\Ohio\Cleveland\Cleveland;
use Carbon\Carbon;
use TestCase;

class ClevelandTest extends TestCase
{
    public function testCleveland_no_birth_date()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(null);
        $this->assertSame(7.50, $results->getTax(Cleveland::class));
    }

    public function testCleveland_over_18()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(Carbon::now()->subYears(19));
        $this->assertSame(7.50, $results->getTax(Cleveland::class));
    }

    public function testCleveland_18()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(Carbon::now()->subYears(18));
        $this->assertSame(7.50, $results->getTax(Cleveland::class));
    }

    public function testCleveland_under_18()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(Carbon::now()->subYears(17));
        $this->assertNull($results->getTax(Cleveland::class));
    }

    private function calculateTaxes(?Carbon $birth_date): TaxResults
    {
        return $this->taxes->calculate(function ($taxes) use ($birth_date) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.cleveland'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.cleveland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setBirthDate($birth_date);
        });
    }
}
