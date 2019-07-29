<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\OhioCity\OhioCity;
use Carbon\Carbon;
use TestCase;

class OhioCityTest extends TestCase
{
    public function testOhioCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.ohio_city'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.ohio_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(OhioCity::class));
    }
}
