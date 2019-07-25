<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Avon\Avon;
use Carbon\Carbon;
use TestCase;

class AvonTest extends TestCase
{
    public function testAvon()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.avon'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.avon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.25, $results->getTax(Avon::class));
    }
}
