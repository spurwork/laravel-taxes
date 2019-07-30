<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MorelandHills\MorelandHills;
use Carbon\Carbon;
use TestCase;

class MorelandHillsTest extends TestCase
{
    public function testMorelandHills()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.moreland_hills'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.moreland_hills'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(MorelandHills::class));
    }
}
