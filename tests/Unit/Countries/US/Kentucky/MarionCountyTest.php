<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\MarionCounty\MarionCounty;
use Carbon\Carbon;
use TestCase;

class MarionCountyTest extends TestCase
{
    public function testMarionCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.marion_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.marion_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(MarionCounty::class));
    }
}
