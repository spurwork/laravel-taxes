<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\WestfieldCenter\WestfieldCenter;
use Carbon\Carbon;
use TestCase;

class WestfieldCenterTest extends TestCase
{
    public function testWestfieldCenter()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.westfield_center'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.westfield_center'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(WestfieldCenter::class));
    }
}
