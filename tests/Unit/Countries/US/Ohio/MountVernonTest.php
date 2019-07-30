<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MountVernon\MountVernon;
use Carbon\Carbon;
use TestCase;

class MountVernonTest extends TestCase
{
    public function testMountVernon()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mount_vernon'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mount_vernon'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(MountVernon::class));
    }
}
