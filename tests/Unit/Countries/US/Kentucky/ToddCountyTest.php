<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\ToddCounty\ToddCounty;
use Carbon\Carbon;
use TestCase;

class ToddCountyTest extends TestCase
{
    public function testToddCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.todd_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.todd_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(ToddCounty::class));
    }
}
