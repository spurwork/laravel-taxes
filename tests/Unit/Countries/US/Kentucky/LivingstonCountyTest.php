<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\LivingstonCounty\LivingstonCounty;
use Carbon\Carbon;
use TestCase;

class LivingstonCountyTest extends TestCase
{
    public function testLivingstonCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.livingston_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.livingston_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(LivingstonCounty::class));
    }
}
