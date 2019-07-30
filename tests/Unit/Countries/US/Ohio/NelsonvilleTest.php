<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Nelsonville\Nelsonville;
use Carbon\Carbon;
use TestCase;

class NelsonvilleTest extends TestCase
{
    public function testNelsonville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.nelsonville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.nelsonville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.25, $results->getTax(Nelsonville::class));
    }
}
