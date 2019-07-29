<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\OakwoodPauldingCounty\OakwoodPauldingCounty;
use Carbon\Carbon;
use TestCase;

class OakwoodPauldingCountyTest extends TestCase
{
    public function testOakwoodPauldingCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.oakwood_paulding_county'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.oakwood_paulding_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(OakwoodPauldingCounty::class));
    }
}
