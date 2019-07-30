<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\CanalWinchester\CanalWinchester;
use Carbon\Carbon;
use TestCase;

class CanalWinchesterTest extends TestCase
{
    public function testCanalWinchester()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.canal_winchester'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.canal_winchester'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(CanalWinchester::class));
    }
}
