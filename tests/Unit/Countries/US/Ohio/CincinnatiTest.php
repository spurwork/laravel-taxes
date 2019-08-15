<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Classes\TaxResults;
use Appleton\Taxes\Countries\US\Ohio\Cincinnati\Cincinnati;
use Carbon\Carbon;
use TestCase;

class CincinnatiTest extends TestCase
{
    public function testCincinnati_over_18()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(Carbon::now()->subYears(19));
        $this->assertSame(6.30, $results->getTax(Cincinnati::class));
    }

    public function testCincinnati_18()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(Carbon::now()->subYears(18));
        $this->assertSame(6.30, $results->getTax(Cincinnati::class));
    }

    public function testCincinnati_under_18()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(Carbon::now()->subYears(17));
        $this->assertNull($results->getTax(Cincinnati::class));
    }

    private function calculateTaxes(Carbon $birth_date): TaxResults
    {
        return $this->taxes->calculate(function ($taxes) use ($birth_date) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.cincinnati'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.cincinnati'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setBirthDate($birth_date);
        });
    }
}
