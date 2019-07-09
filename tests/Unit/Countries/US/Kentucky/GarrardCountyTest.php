<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\GarrardCounty\GarrardCounty;
use Carbon\Carbon;
use TestCase;

class GarrardCountyTest extends TestCase
{
    public function testGarrardCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.garrard_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.garrard_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(GarrardCounty::class));
    }
}
