<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\BeattyvilleCity\BeattyvilleCity;
use Carbon\Carbon;
use TestCase;

class BeattyvilleCityTest extends TestCase
{
    public function testBeattyvilleCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.beattyville_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.beattyville_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(BeattyvilleCity::class));
    }
}
