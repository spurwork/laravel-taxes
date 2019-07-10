<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\HillviewCity\HillviewCity;
use Carbon\Carbon;
use TestCase;

class HillviewCityTest extends TestCase
{
    public function testHillviewCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.hillview_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.hillview_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.40, $results->getTax(HillviewCity::class));
    }
}
