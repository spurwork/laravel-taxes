<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Westerville\Westerville;
use Carbon\Carbon;
use TestCase;

class WestervilleTest extends TestCase
{
    public function testWesterville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.westerville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.westerville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Westerville::class));
    }
}
