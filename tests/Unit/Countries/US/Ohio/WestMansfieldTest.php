<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\WestMansfield\WestMansfield;
use Carbon\Carbon;
use TestCase;

class WestMansfieldTest extends TestCase
{
    public function testWestMansfield()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.west_mansfield'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.west_mansfield'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(WestMansfield::class));
    }
}
