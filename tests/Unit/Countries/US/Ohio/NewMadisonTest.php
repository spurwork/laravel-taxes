<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\NewMadison\NewMadison;
use Carbon\Carbon;
use TestCase;

class NewMadisonTest extends TestCase
{
    public function testNewMadison()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.new_madison'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.new_madison'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(NewMadison::class));
    }
}
