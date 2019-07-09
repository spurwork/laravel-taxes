<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\MercerCounty\MercerCounty;
use Carbon\Carbon;
use TestCase;

class MercerCountyTest extends TestCase
{
    public function testMercerCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.mercer_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.mercer_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(1.35, $results->getTax(MercerCounty::class));
    }
}
