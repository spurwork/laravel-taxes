<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\ClarksonCity\ClarksonCity;
use Carbon\Carbon;
use TestCase;

class ClarksonCityTest extends TestCase
{
    public function testClarksonCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.clarkson_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.clarkson_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.60, $results->getTax(ClarksonCity::class));
    }
}
