<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\SouthCharleston\SouthCharleston;
use Carbon\Carbon;
use TestCase;

class SouthCharlestonTest extends TestCase
{
    public function testSouthCharleston()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.south_charleston'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.south_charleston'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(SouthCharleston::class));
    }
}
