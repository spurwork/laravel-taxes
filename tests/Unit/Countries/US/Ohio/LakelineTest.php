<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Lakeline\Lakeline;
use Carbon\Carbon;
use TestCase;

class LakelineTest extends TestCase
{
    public function testLakeline()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.lakeline'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.lakeline'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Lakeline::class));
    }
}
