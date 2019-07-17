<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Zanesville\Zanesville;
use Carbon\Carbon;
use TestCase;

class ZanesvilleTest extends TestCase
{
    public function testZanesville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.zanesville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.zanesville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.70, $results->getTax(Zanesville::class));
    }
}
