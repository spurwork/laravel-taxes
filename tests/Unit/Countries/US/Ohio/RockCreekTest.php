<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\RockCreek\RockCreek;
use Carbon\Carbon;
use TestCase;

class RockCreekTest extends TestCase
{
    public function testRockCreek()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.rock_creek'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.rock_creek'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(RockCreek::class));
    }
}
