<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\SouthSolon\SouthSolon;
use Carbon\Carbon;
use TestCase;

class SouthSolonTest extends TestCase
{
    public function testSouthSolon()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.south_solon'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.south_solon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(SouthSolon::class));
    }
}
