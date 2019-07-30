<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NewBloomington\NewBloomington;
use Carbon\Carbon;
use TestCase;

class NewBloomingtonTest extends TestCase
{
    public function testNewBloomington()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.new_bloomington'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.new_bloomington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(NewBloomington::class));
    }
}
