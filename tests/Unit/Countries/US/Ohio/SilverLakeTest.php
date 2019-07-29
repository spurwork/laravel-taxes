<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\SilverLake\SilverLake;
use Carbon\Carbon;
use TestCase;

class SilverLakeTest extends TestCase
{
    public function testSilverLake()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.silver_lake'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.silver_lake'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(SilverLake::class));
    }
}
