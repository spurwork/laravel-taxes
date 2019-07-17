<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\PlainCity\PlainCity;
use Carbon\Carbon;
use TestCase;

class PlainCityTest extends TestCase
{
    public function testPlainCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.plain_city'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.plain_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(PlainCity::class));
    }
}
