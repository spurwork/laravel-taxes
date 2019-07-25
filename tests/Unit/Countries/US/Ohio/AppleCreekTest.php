<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\AppleCreek\AppleCreek;
use Carbon\Carbon;
use TestCase;

class AppleCreekTest extends TestCase
{
    public function testAppleCreek()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.apple_creek'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.apple_creek'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(AppleCreek::class));
    }
}
