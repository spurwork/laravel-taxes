<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\SevenHills\SevenHills;
use Carbon\Carbon;
use TestCase;

class SevenHillsTest extends TestCase
{
    public function testSevenHills()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.seven_hills'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.seven_hills'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(7.50, $results->getTax(SevenHills::class));
    }
}
