<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\RobertsonCounty\RobertsonCounty;
use Carbon\Carbon;
use TestCase;

class RobertsonCountyTest extends TestCase
{
    public function testRobertsonCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.robertson_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.robertson_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(RobertsonCounty::class));
    }
}
