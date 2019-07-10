<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\GallatinCounty\GallatinCounty;
use Carbon\Carbon;
use TestCase;

class GallatinCountyTest extends TestCase
{
    public function testGallatinCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.gallatin_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.gallatin_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(GallatinCounty::class));
    }
}
