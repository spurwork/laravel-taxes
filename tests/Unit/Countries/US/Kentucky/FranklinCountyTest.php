<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\FranklinCounty\FranklinCounty;
use Carbon\Carbon;
use TestCase;

class FranklinCountyTest extends TestCase
{
    public function testFranklinCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.franklin_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.franklin_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(FranklinCounty::class));
    }
}
