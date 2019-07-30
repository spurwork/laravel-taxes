<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MayfieldHeights\MayfieldHeights;
use Carbon\Carbon;
use TestCase;

class MayfieldHeightsTest extends TestCase
{
    public function testMayfieldHeights()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mayfield_heights'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mayfield_heights'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(MayfieldHeights::class));
    }
}
