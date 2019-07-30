<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\HighlandHills\HighlandHills;
use Carbon\Carbon;
use TestCase;

class HighlandHillsTest extends TestCase
{
    public function testHighlandHills()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.highland_hills'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.highland_hills'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(7.50, $results->getTax(HighlandHills::class));
    }
}
