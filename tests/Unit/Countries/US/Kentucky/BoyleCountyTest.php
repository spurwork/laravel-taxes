<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\BoyleCounty\BoyleCounty;
use Carbon\Carbon;
use TestCase;

class BoyleCountyTest extends TestCase
{
    public function testBoyleCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.boyle_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.boyle_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.25, $results->getTax(BoyleCounty::class));
    }
}
