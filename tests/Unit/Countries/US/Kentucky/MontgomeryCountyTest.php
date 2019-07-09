<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\MontgomeryCounty\MontgomeryCounty;
use Carbon\Carbon;
use TestCase;

class MontgomeryCountyTest extends TestCase
{
    public function testMontgomeryCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.montgomery_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.montgomery_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(MontgomeryCounty::class));
    }
}
