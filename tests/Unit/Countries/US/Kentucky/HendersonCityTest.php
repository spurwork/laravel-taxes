<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\HendersonCity\HendersonCity;
use Carbon\Carbon;
use TestCase;

class HendersonCityTest extends TestCase
{
    public function testHendersonCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.henderson_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.henderson_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.87, $results->getTax(HendersonCity::class));
    }
}
