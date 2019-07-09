<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\TaylorMillCity\TaylorMillCity;
use Carbon\Carbon;
use TestCase;

class TaylorMillCityTest extends TestCase
{
    public function testTaylorMillCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.taylor_mill_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.taylor_mill_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(TaylorMillCity::class));
    }
}
