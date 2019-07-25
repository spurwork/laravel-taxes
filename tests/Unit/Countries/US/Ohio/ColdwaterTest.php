<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Coldwater\Coldwater;
use Carbon\Carbon;
use TestCase;

class ColdwaterTest extends TestCase
{
    public function testColdwater()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.coldwater'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.coldwater'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Coldwater::class));
    }
}
