<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Ottawa\Ottawa;
use Carbon\Carbon;
use TestCase;

class OttawaTest extends TestCase
{
    public function testOttawa()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.ottawa'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.ottawa'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Ottawa::class));
    }
}
