<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\FrankfortCity\FrankfortCity;
use Carbon\Carbon;
use TestCase;

class FrankfortCityTest extends TestCase
{
    public function testFrankfortCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.frankfort_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.frankfort_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.85, $results->getTax(FrankfortCity::class));
    }
}
