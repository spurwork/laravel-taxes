<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\JEDD;

use Appleton\Taxes\Countries\US\Ohio\JEDD\RushUhrichsville\RushUhrichsville;
use Carbon\Carbon;
use TestCase;

class RushUhrichsvilleTest extends TestCase
{
    public function testRushUhrichsville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setAdditionalTaxes([RushUhrichsville::class]);
        });

        $this->assertSame(6.0, $results->getTax(RushUhrichsville::class));
    }
}
