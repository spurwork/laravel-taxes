<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Lockland\Lockland;
use Carbon\Carbon;
use TestCase;

class LocklandTest extends TestCase
{
    public function testLockland()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.lockland'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.lockland'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.30, $results->getTax(Lockland::class));
    }
}
