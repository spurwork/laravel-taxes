<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\RussellCity\RussellCity;
use Carbon\Carbon;
use TestCase;

class RussellCityTest extends TestCase
{
    public function testRussellCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.russell_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.russell_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.45, $results->getTax(RussellCity::class));
    }
}
