<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MountGilead\MountGilead;
use Carbon\Carbon;
use TestCase;

class MountGileadTest extends TestCase
{
    public function testMountGilead()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mount_gilead'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mount_gilead'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(MountGilead::class));
    }
}
