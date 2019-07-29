<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Campbell\Campbell;
use Carbon\Carbon;
use TestCase;

class CampbellTest extends TestCase
{
    public function testCampbell()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.campbell'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.campbell'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(7.50, $results->getTax(Campbell::class));
    }
}
