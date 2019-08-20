<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\KentonCounty\KentonCounty;
use Carbon\Carbon;
use TestCase;

class KentonCountyTest extends TestCase
{
    public function testKentonCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.kenton_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.kenton_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.13, $results->getTax(KentonCounty::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.kenton_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.kenton_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setYtdEarnings(25000);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(0.33, $results->getTax(KentonCounty::class));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.kenton_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.kenton_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setYtdEarnings(132900);
            $taxes->setPayPeriods(52);
        });

        $this->assertNull($results->getTax(KentonCounty::class));
    }
}
