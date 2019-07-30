<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\PowhatanPoint\PowhatanPoint;
use Carbon\Carbon;
use TestCase;

class PowhatanPointTest extends TestCase
{
    public function testPowhatanPoint()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.powhatan_point'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.powhatan_point'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(PowhatanPoint::class));
    }
}
