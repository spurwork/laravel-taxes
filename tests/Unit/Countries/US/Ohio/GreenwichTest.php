<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Greenwich\Greenwich;
use Carbon\Carbon;
use TestCase;

class GreenwichTest extends TestCase
{
    public function testGreenwich()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.greenwich'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.greenwich'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Greenwich::class));
    }
}
