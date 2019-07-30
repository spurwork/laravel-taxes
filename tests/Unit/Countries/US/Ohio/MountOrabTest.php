<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MountOrab\MountOrab;
use Carbon\Carbon;
use TestCase;

class MountOrabTest extends TestCase
{
    public function testMountOrab()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mount_orab'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mount_orab'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.05, $results->getTax(MountOrab::class));
    }
}
