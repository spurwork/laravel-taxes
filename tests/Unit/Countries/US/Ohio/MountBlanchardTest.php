<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MountBlanchard\MountBlanchard;
use Carbon\Carbon;
use TestCase;

class MountBlanchardTest extends TestCase
{
    public function testMountBlanchard()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.mount_blanchard'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.mount_blanchard'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(MountBlanchard::class));
    }
}
