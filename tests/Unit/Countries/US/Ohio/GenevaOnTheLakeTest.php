<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio;

use Appleton\Taxes\Countries\US\Ohio\GenevaOnTheLake\GenevaOnTheLake;
use Carbon\Carbon;
use TestCase;

class GenevaOnTheLakeTest extends TestCase
{
    public function testGenevaOnTheLake()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.ohio.geneva_on_the_lake'));
            $taxes->setWorkLocation($this->getLocation('us.ohio.geneva_on_the_lake'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(4.50, $results->getTax(GenevaOnTheLake::class));
    }
}
