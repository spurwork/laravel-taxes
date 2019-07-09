<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\SomersetCity\SomersetCity;
use Carbon\Carbon;
use TestCase;

class SomersetCityTest extends TestCase
{
    public function testSomersetCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.somerset_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.somerset_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(1.80, $results->getTax(SomersetCity::class));
    }
}
