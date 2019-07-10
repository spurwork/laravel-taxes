<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\MorgantownCity\MorgantownCity;
use Carbon\Carbon;
use TestCase;

class MorgantownCityTest extends TestCase
{
    public function testMorgantownCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.morgantown_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.morgantown_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(MorgantownCity::class));
    }
}
