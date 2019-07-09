<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\EdgewoodCity\EdgewoodCity;
use Carbon\Carbon;
use TestCase;

class EdgewoodCityTest extends TestCase
{
    public function testEdgewoodCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.edgewood_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.edgewood_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(EdgewoodCity::class));
    }
}
