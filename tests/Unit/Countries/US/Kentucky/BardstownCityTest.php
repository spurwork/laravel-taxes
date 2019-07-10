<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\BardstownCity\BardstownCity;
use Carbon\Carbon;
use TestCase;

class BardstownCityTest extends TestCase
{
    public function testBardstownCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.bardstown_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.bardstown_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(BardstownCity::class));
    }
}
