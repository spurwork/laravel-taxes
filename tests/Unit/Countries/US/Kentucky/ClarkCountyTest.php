<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\ClarkCounty\ClarkCounty;
use Carbon\Carbon;
use TestCase;

class ClarkCountyTest extends TestCase
{
    public function testClarkCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.clark_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.clark_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(ClarkCounty::class));
    }
}
