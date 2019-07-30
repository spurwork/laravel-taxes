<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\SouthAmherst\SouthAmherst;
use Carbon\Carbon;
use TestCase;

class SouthAmherstTest extends TestCase
{
    public function testSouthAmherst()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.south_amherst'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.south_amherst'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(SouthAmherst::class));
    }
}
