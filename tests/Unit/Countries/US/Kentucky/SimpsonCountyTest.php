<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\SimpsonCounty\SimpsonCounty;
use Carbon\Carbon;
use TestCase;

class SimpsonCountyTest extends TestCase
{
    public function testSimpsonCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.simpson_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.simpson_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.25, $results->getTax(SimpsonCounty::class));
    }
}
