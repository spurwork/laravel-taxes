<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\PulaskiCounty\PulaskiCounty;
use Carbon\Carbon;
use TestCase;

class PulaskiCountyTest extends TestCase
{
    public function testPulaskiCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.pulaski_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.pulaski_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(PulaskiCounty::class));
    }
}
