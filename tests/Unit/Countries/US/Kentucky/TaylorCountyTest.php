<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\TaylorCounty\TaylorCounty;
use Carbon\Carbon;
use TestCase;

class TaylorCountyTest extends TestCase
{
    public function testTaylorCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.taylor_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.taylor_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(TaylorCounty::class));
    }
}
