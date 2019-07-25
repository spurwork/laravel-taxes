<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Trenton\Trenton;
use Carbon\Carbon;
use TestCase;

class TrentonTest extends TestCase
{
    public function testTrenton()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.trenton'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.trenton'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Trenton::class));
    }
}
