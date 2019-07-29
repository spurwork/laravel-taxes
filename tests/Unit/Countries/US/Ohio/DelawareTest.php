<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Delaware\Delaware;
use Carbon\Carbon;
use TestCase;

class DelawareTest extends TestCase
{
    public function testDelaware()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.delaware'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.delaware'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.55, $results->getTax(Delaware::class));
    }
}
