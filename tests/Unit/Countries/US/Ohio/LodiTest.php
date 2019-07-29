<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Lodi\Lodi;
use Carbon\Carbon;
use TestCase;

class LodiTest extends TestCase
{
    public function testLodi()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.lodi'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.lodi'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Lodi::class));
    }
}
