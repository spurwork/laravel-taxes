<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\HighlandHeights\HighlandHeights;
use Carbon\Carbon;
use TestCase;

class HighlandHeightsTest extends TestCase
{
    public function testHighlandHeights()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.highland_heights'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.highland_heights'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(HighlandHeights::class));
    }
}
