<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\HartCounty\HartCounty;
use Carbon\Carbon;
use TestCase;

class HartCountyTest extends TestCase
{
    public function testHartCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.hart_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.hart_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.40, $results->getTax(HartCounty::class));
    }
}
