<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Pataskala\Pataskala;
use Carbon\Carbon;
use TestCase;

class PataskalaTest extends TestCase
{
    public function testPataskala()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.pataskala'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.pataskala'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Pataskala::class));
    }
}
