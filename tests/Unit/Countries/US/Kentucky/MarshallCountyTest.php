<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\MarshallCounty\MarshallCounty;
use Carbon\Carbon;
use TestCase;

class MarshallCountyTest extends TestCase
{
    public function testMarshallCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.marshall_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.marshall_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(MarshallCounty::class));
    }
}
