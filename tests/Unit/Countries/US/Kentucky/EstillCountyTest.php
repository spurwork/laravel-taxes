<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\EstillCounty\EstillCounty;
use Carbon\Carbon;
use TestCase;

class EstillCountyTest extends TestCase
{
    public function testEstillCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.estill_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.estill_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.00, $results->getTax(EstillCounty::class));
    }
}
