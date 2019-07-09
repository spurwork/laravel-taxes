<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\WayneCounty\WayneCounty;
use Carbon\Carbon;
use TestCase;

class WayneCountyTest extends TestCase
{
    public function testWayneCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.wayne_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.wayne_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.70, $results->getTax(WayneCounty::class));
    }
}
