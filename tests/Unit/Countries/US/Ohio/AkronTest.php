<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Classes\TaxResults;
use Appleton\Taxes\Countries\US\Ohio\Akron\Akron;
use Carbon\Carbon;
use TestCase;

class AkronTest extends TestCase
{
    public function testAkron_over_18()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(Carbon::now()->subYears(19));
        $this->assertSame(7.50, $results->getTax(Akron::class));
    }

    public function testAkron_18()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(Carbon::now()->subYears(18));
        $this->assertSame(7.50, $results->getTax(Akron::class));
    }

    public function testAkron_18_by_end_of_year()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(Carbon::now()->subYears(18)->addMonths(1));
        $this->assertSame(7.50, $results->getTax(Akron::class));
    }

    public function testAkron_under_18()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->calculateTaxes(Carbon::now()->subYears(17));
        $this->assertNull($results->getTax(Akron::class));
    }

    private function calculateTaxes(Carbon $birth_date): TaxResults
    {
        return $this->taxes->calculate(function ($taxes) use ($birth_date) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.akron'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.akron'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setBirthDate($birth_date);
        });
    }
}
