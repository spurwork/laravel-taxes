<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\GarfieldHeights\GarfieldHeights;
use Carbon\Carbon;
use TestCase;

class GarfieldHeightsTest extends TestCase
{
    public function testGarfieldHeights()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.garfield_heights'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.garfield_heights'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(GarfieldHeights::class));
    }
}
