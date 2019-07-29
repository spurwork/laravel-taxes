<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\BlueAsh\BlueAsh;
use Carbon\Carbon;
use TestCase;

class BlueAshTest extends TestCase
{
    public function testBlueAsh()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.blue_ash'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.blue_ash'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(BlueAsh::class));
    }
}
