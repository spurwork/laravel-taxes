<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\JerryCity\JerryCity;
use Carbon\Carbon;
use TestCase;

class JerryCityTest extends TestCase
{
    public function testJerryCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.jerry_city'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.jerry_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(JerryCity::class));
    }
}
