<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MountCory\MountCory;
use Carbon\Carbon;
use TestCase;

class MountCoryTest extends TestCase
{
    public function testMountCory()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mount_cory'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mount_cory'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(MountCory::class));
    }
}
