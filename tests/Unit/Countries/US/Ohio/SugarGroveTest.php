<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\SugarGrove\SugarGrove;
use Carbon\Carbon;
use TestCase;

class SugarGroveTest extends TestCase
{
    public function testSugarGrove()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.sugar_grove'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.sugar_grove'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.25, $results->getTax(SugarGrove::class));
    }
}
