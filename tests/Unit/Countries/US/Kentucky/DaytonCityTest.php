<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\DaytonCity\DaytonCity;
use Carbon\Carbon;
use TestCase;

class DaytonCityTest extends TestCase
{
    public function testDaytonCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.dayton_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.dayton_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(DaytonCity::class));
    }
}
