<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\WestSalem\WestSalem;
use Carbon\Carbon;
use TestCase;

class WestSalemTest extends TestCase
{
    public function testWestSalem()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.west_salem'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.west_salem'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(WestSalem::class));
    }
}
