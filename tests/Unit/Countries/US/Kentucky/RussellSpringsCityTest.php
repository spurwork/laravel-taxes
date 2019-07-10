<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\RussellSpringsCity\RussellSpringsCity;
use Carbon\Carbon;
use TestCase;

class RussellSpringsCityTest extends TestCase
{
    public function testRussellSpringsCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.russell_springs_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.russell_springs_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(RussellSpringsCity::class));
    }
}
