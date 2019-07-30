<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Uhrichsville\Uhrichsville;
use Carbon\Carbon;
use TestCase;

class UhrichsvilleTest extends TestCase
{
    public function testUhrichsville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.uhrichsville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.uhrichsville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Uhrichsville::class));
    }
}
