<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\CaldwellCounty\CaldwellCounty;
use Carbon\Carbon;
use TestCase;

class CaldwellCountyTest extends TestCase
{
    public function testCaldwellCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.caldwell_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.caldwell_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(CaldwellCounty::class));
    }
}
