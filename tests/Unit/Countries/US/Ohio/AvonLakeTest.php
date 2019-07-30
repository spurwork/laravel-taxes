<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\AvonLake\AvonLake;
use Carbon\Carbon;
use TestCase;

class AvonLakeTest extends TestCase
{
    public function testAvonLake()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.avon_lake'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.avon_lake'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(AvonLake::class));
    }
}
