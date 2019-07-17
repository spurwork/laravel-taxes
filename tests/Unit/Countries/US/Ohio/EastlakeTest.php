<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Eastlake\Eastlake;
use Carbon\Carbon;
use TestCase;

class EastlakeTest extends TestCase
{
    public function testEastlake()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.eastlake'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.eastlake'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(Eastlake::class));
    }
}
