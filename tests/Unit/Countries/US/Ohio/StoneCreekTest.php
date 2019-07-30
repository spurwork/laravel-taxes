<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\StoneCreek\StoneCreek;
use Carbon\Carbon;
use TestCase;

class StoneCreekTest extends TestCase
{
    public function testStoneCreek()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.stone_creek'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.stone_creek'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(StoneCreek::class));
    }
}
