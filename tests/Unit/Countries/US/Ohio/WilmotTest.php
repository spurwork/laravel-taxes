<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Wilmot\Wilmot;
use Carbon\Carbon;
use TestCase;

class WilmotTest extends TestCase
{
    public function testWilmot()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.wilmot'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.wilmot'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.25, $results->getTax(Wilmot::class));
    }
}
