<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\BowlingGreen\BowlingGreen;
use Carbon\Carbon;
use TestCase;

class BowlingGreenTest extends TestCase
{
    public function testBowlingGreen()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.bowling_green'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.bowling_green'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(BowlingGreen::class));
    }
}
