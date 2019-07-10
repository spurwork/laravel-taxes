<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\LeitchfieldCity\LeitchfieldCity;
use Carbon\Carbon;
use TestCase;

class LeitchfieldCityTest extends TestCase
{
    public function testLeitchfieldCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.leitchfield_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.leitchfield_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.60, $results->getTax(LeitchfieldCity::class));
    }
}
