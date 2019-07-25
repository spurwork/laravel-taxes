<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NewWaterford\NewWaterford;
use Carbon\Carbon;
use TestCase;

class NewWaterfordTest extends TestCase
{
    public function testNewWaterford()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.new_waterford'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.new_waterford'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(NewWaterford::class));
    }
}
