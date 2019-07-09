<?php

namespace Appleton\Taxes\Unit\Countries\US\Kentucky;

use Appleton\Taxes\Countries\US\Kentucky\LexingtonFayetteUrbanCounty\LexingtonFayetteUrbanCounty;
use Carbon\Carbon;
use TestCase;

class LexingtonFayetteUrbanCountyTest extends TestCase
{
    public function testLexingtonFayetteUrbanCounty()
    {
        Carbon::setTestNow(Carbon::parse('2019-02-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.kentucky.fayette_county'));
            $taxes->setWorkLocation($this->getLocation('us.kentucky.fayette_county'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(6.75, $results->getTax(LexingtonFayetteUrbanCounty::class));
    }
}
