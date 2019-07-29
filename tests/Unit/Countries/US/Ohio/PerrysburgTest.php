<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Perrysburg\Perrysburg;
use Carbon\Carbon;
use TestCase;

class PerrysburgTest extends TestCase
{
    public function testPerrysburg()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.perrysburg'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.perrysburg'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(Perrysburg::class));
    }
}
