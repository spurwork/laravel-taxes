<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Wauseon\Wauseon;
use Carbon\Carbon;
use TestCase;

class WauseonTest extends TestCase
{
    public function testWauseon()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.wauseon'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.wauseon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Wauseon::class));
    }
}
