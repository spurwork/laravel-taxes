<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Hicksville\Hicksville;
use Carbon\Carbon;
use TestCase;

class HicksvilleTest extends TestCase
{
    public function testHicksville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.hicksville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.hicksville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Hicksville::class));
    }
}
