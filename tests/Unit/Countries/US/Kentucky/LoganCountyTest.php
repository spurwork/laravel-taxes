<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\LoganCounty\LoganCounty;
use Carbon\Carbon;
use TestCase;

class LoganCountyTest extends TestCase
{
    public function testLoganCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.logan_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.logan_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.25, $results->getTax(LoganCounty::class));
    }
}
