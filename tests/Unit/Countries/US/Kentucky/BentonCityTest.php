<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\BentonCity\BentonCity;
use Carbon\Carbon;
use TestCase;

class BentonCityTest extends TestCase
{
    public function testBentonCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.benton_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.benton_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(1.50, $results->getTax(BentonCity::class));
    }
}
