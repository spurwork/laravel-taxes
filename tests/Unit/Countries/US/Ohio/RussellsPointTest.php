<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\RussellsPoint\RussellsPoint;
use Carbon\Carbon;
use TestCase;

class RussellsPointTest extends TestCase
{
    public function testRussellsPoint()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.russells_point'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.russells_point'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(RussellsPoint::class));
    }
}
