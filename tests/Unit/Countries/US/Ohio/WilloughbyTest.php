<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Willoughby\Willoughby;
use Carbon\Carbon;
use TestCase;

class WilloughbyTest extends TestCase
{
    public function testWilloughby()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.willoughby'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.willoughby'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Willoughby::class));
    }
}
