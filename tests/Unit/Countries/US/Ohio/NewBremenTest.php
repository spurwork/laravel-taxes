<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NewBremen\NewBremen;
use Carbon\Carbon;
use TestCase;

class NewBremenTest extends TestCase
{
    public function testNewBremen()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.new_bremen'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.new_bremen'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(NewBremen::class));
    }
}
