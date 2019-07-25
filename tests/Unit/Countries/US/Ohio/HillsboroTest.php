<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Hillsboro\Hillsboro;
use Carbon\Carbon;
use TestCase;

class HillsboroTest extends TestCase
{
    public function testHillsboro()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.hillsboro'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.hillsboro'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Hillsboro::class));
    }
}
