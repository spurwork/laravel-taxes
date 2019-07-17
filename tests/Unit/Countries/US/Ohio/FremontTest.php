<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Fremont\Fremont;
use Carbon\Carbon;
use TestCase;

class FremontTest extends TestCase
{
    public function testFremont()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.fremont'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.fremont'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Fremont::class));
    }
}
