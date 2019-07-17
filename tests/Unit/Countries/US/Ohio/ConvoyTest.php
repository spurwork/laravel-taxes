<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Convoy\Convoy;
use Carbon\Carbon;
use TestCase;

class ConvoyTest extends TestCase
{
    public function testConvoy()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.convoy'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.convoy'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Convoy::class));
    }
}
