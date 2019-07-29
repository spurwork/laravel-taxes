<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Lakemore\Lakemore;
use Carbon\Carbon;
use TestCase;

class LakemoreTest extends TestCase
{
    public function testLakemore()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.lakemore'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.lakemore'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.75, $results->getTax(Lakemore::class));
    }
}
