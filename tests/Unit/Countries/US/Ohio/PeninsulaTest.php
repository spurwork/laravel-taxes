<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Peninsula\Peninsula;
use Carbon\Carbon;
use TestCase;

class PeninsulaTest extends TestCase
{
    public function testPeninsula()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.peninsula'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.peninsula'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Peninsula::class));
    }
}
