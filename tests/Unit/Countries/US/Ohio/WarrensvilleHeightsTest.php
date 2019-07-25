<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\WarrensvilleHeights\WarrensvilleHeights;
use Carbon\Carbon;
use TestCase;

class WarrensvilleHeightsTest extends TestCase
{
    public function testWarrensvilleHeights()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.warrensville_heights'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.warrensville_heights'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(7.80, $results->getTax(WarrensvilleHeights::class));
    }
}
