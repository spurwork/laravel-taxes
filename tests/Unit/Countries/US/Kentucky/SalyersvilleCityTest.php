<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\SalyersvilleCity\SalyersvilleCity;
use Carbon\Carbon;
use TestCase;

class SalyersvilleCityTest extends TestCase
{
    public function testSalyersvilleCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.salyersville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.salyersville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(SalyersvilleCity::class));
    }
}
