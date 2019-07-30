<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NorthKingsville\NorthKingsville;
use Carbon\Carbon;
use TestCase;

class NorthKingsvilleTest extends TestCase
{
    public function testNorthKingsville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.north_kingsville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.north_kingsville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.90, $results->getTax(NorthKingsville::class));
    }
}
