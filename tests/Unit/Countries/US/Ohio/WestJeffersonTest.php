<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\WestJefferson\WestJefferson;
use Carbon\Carbon;
use TestCase;

class WestJeffersonTest extends TestCase
{
    public function testWestJefferson()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.west_jefferson'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.west_jefferson'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(WestJefferson::class));
    }
}
