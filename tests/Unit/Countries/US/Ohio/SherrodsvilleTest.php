<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Sherrodsville\Sherrodsville;
use Carbon\Carbon;
use TestCase;

class SherrodsvilleTest extends TestCase
{
    public function testSherrodsville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.sherrodsville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.sherrodsville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Sherrodsville::class));
    }
}
