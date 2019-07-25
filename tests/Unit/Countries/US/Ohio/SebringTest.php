<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Sebring\Sebring;
use Carbon\Carbon;
use TestCase;

class SebringTest extends TestCase
{
    public function testSebring()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.sebring'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.sebring'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Sebring::class));
    }
}
