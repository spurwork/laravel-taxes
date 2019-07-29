<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\LibertyCenter\LibertyCenter;
use Carbon\Carbon;
use TestCase;

class LibertyCenterTest extends TestCase
{
    public function testLibertyCenter()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.liberty_center'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.liberty_center'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(LibertyCenter::class));
    }
}
