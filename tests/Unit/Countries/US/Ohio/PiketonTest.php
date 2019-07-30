<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Piketon\Piketon;
use Carbon\Carbon;
use TestCase;

class PiketonTest extends TestCase
{
    public function testPiketon()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.piketon'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.piketon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Piketon::class));
    }
}
