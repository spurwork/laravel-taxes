<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Middleport\Middleport;
use Carbon\Carbon;
use TestCase;

class MiddleportTest extends TestCase
{
    public function testMiddleport()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.middleport'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.middleport'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Middleport::class));
    }
}
