<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\SouthBloomfield\SouthBloomfield;
use Carbon\Carbon;
use TestCase;

class SouthBloomfieldTest extends TestCase
{
    public function testSouthBloomfield()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.south_bloomfield'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.south_bloomfield'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(SouthBloomfield::class));
    }
}
