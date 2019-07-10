<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\RowanCounty\RowanCounty;
use Carbon\Carbon;
use TestCase;

class RowanCountyTest extends TestCase
{
    public function testRowanCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.rowan_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.rowan_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(RowanCounty::class));
    }
}
