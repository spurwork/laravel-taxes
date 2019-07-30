<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Kirtland\Kirtland;
use Carbon\Carbon;
use TestCase;

class KirtlandTest extends TestCase
{
    public function testKirtland()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.kirtland'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.kirtland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Kirtland::class));
    }
}
