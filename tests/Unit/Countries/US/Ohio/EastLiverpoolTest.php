<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\EastLiverpool\EastLiverpool;
use Carbon\Carbon;
use TestCase;

class EastLiverpoolTest extends TestCase
{
    public function testEastLiverpool()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.east_liverpool'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.east_liverpool'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(EastLiverpool::class));
    }
}
