<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Greenfield\Greenfield;
use Carbon\Carbon;
use TestCase;

class GreenfieldTest extends TestCase
{
    public function testGreenfield()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.greenfield'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.greenfield'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.88, $results->getTax(Greenfield::class));
    }
}
