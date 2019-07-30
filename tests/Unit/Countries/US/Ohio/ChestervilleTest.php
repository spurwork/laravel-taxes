<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Chesterville\Chesterville;
use Carbon\Carbon;
use TestCase;

class ChestervilleTest extends TestCase
{
    public function testChesterville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.chesterville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.chesterville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Chesterville::class));
    }
}
