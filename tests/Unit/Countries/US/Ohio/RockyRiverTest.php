<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\RockyRiver\RockyRiver;
use Carbon\Carbon;
use TestCase;

class RockyRiverTest extends TestCase
{
    public function testRockyRiver()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.rocky_river'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.rocky_river'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(RockyRiver::class));
    }
}
