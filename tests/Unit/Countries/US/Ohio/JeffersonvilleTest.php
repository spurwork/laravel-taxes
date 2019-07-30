<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Jeffersonville\Jeffersonville;
use Carbon\Carbon;
use TestCase;

class JeffersonvilleTest extends TestCase
{
    public function testJeffersonville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.jeffersonville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.jeffersonville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Jeffersonville::class));
    }
}
