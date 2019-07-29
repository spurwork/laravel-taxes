<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Danville\Danville;
use Carbon\Carbon;
use TestCase;

class DanvilleTest extends TestCase
{
    public function testDanville()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.danville'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.danville'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Danville::class));
    }
}
