<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\Kalida\Kalida;
use Carbon\Carbon;
use TestCase;

class KalidaTest extends TestCase
{
    public function testKalida()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.kalida'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.kalida'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(3.00, $results->getTax(Kalida::class));
    }
}
