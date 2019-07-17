<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\GroveCity\GroveCity;
use Carbon\Carbon;
use TestCase;

class GroveCityTest extends TestCase
{
    public function testGroveCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.grove_city'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.grove_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(GroveCity::class));
    }
}
