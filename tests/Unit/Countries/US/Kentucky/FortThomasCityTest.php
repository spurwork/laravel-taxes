<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\FortThomasCity\FortThomasCity;
use Carbon\Carbon;
use TestCase;

class FortThomasCityTest extends TestCase
{
    public function testFortThomasCity()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.fort_thomas_city'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.fort_thomas_city'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.75, $results->getTax(FortThomasCity::class));
    }
}
