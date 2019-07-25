<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\TremontCity\TremontCity;
use Carbon\Carbon;
use TestCase;

class TremontCityTest extends TestCase
{
    public function testTremontCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.tremont_city'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.tremont_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(TremontCity::class));
    }
}
