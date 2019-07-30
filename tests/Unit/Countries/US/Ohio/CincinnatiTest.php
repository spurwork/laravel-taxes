<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Cincinnati\Cincinnati;
use Carbon\Carbon;
use TestCase;

class CincinnatiTest extends TestCase
{
    public function testCincinnati()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.cincinnati'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.cincinnati'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.30, $results->getTax(Cincinnati::class));
    }
}
