<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\WhitleyCounty\WhitleyCounty;
use Carbon\Carbon;
use TestCase;

class WhitleyCountyTest extends TestCase
{
    public function testWhitleyCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.whitley_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.whitley_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(WhitleyCounty::class));
    }
}
