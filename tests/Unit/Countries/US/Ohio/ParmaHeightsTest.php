<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\ParmaHeights\ParmaHeights;
use Carbon\Carbon;
use TestCase;

class ParmaHeightsTest extends TestCase
{
    public function testParmaHeights()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.parma_heights'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.parma_heights'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(9.00, $results->getTax(ParmaHeights::class));
    }
}
