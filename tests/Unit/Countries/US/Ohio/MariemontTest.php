<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Mariemont\Mariemont;
use Carbon\Carbon;
use TestCase;

class MariemontTest extends TestCase
{
    public function testMariemont()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mariemont'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mariemont'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(Mariemont::class));
    }
}
