<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\ClintonCounty\ClintonCounty;
use Carbon\Carbon;
use TestCase;

class ClintonCountyTest extends TestCase
{
    public function testClintonCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.clinton_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.clinton_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(ClintonCounty::class));
    }
}
