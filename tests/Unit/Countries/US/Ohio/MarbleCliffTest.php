<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MarbleCliff\MarbleCliff;
use Carbon\Carbon;
use TestCase;

class MarbleCliffTest extends TestCase
{
    public function testMarbleCliff()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.marble_cliff'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.marble_cliff'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(MarbleCliff::class));
    }
}
