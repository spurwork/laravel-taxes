<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\PikeCounty\PikeCounty;
use Carbon\Carbon;
use TestCase;

class PikeCountyTest extends TestCase
{
    public function testPikeCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.pike_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.pike_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(PikeCounty::class));
    }
}
