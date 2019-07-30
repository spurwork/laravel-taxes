<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\MinervaPark\MinervaPark;
use Carbon\Carbon;
use TestCase;

class MinervaParkTest extends TestCase
{
    public function testMinervaPark()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.minerva_park'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.minerva_park'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(MinervaPark::class));
    }
}
