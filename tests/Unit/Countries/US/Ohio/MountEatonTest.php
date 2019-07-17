<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MountEaton\MountEaton;
use Carbon\Carbon;
use TestCase;

class MountEatonTest extends TestCase
{
    public function testMountEaton()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mount_eaton'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mount_eaton'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(MountEaton::class));
    }
}
