<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\McCrackenCounty\McCrackenCounty;
use Carbon\Carbon;
use TestCase;

class McCrackenCountyTest extends TestCase
{
    public function testMcCrackenCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.mccracken_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.mccracken_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(McCrackenCounty::class));
    }
}
