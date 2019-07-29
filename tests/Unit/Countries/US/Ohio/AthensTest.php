<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Athens\Athens;
use Carbon\Carbon;
use TestCase;

class AthensTest extends TestCase
{
    public function testAthens()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.athens'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.athens'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.55, $results->getTax(Athens::class));
    }
}
