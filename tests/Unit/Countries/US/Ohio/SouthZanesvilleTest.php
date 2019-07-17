<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\SouthZanesville\SouthZanesville;
use Carbon\Carbon;
use TestCase;

class SouthZanesvilleTest extends TestCase
{
    public function testSouthZanesville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.south_zanesville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.south_zanesville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(SouthZanesville::class));
    }
}
