<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\SouthEuclid\SouthEuclid;
use Carbon\Carbon;
use TestCase;

class SouthEuclidTest extends TestCase
{
    public function testSouthEuclid()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.south_euclid'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.south_euclid'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(SouthEuclid::class));
    }
}
