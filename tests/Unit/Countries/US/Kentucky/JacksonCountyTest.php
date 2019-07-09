<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\JacksonCounty\JacksonCounty;
use Carbon\Carbon;
use TestCase;

class JacksonCountyTest extends TestCase
{
    public function testJacksonCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.jackson_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.jackson_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.55, $results->getTax(JacksonCounty::class));
    }
}
