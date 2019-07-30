<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\TippCity\TippCity;
use Carbon\Carbon;
use TestCase;

class TippCityTest extends TestCase
{
    public function testTippCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.tipp_city'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.tipp_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(TippCity::class));
    }
}
