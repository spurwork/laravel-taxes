<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome;

use Appleton\Taxes\Models\Countries\US\NewMexico\NewMexicoIncomeTaxInformation;
use Carbon\Carbon;

class NewMexicoIncomeTest extends \TestCase
{
    public function testNewMexicoIncome()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(0.95, $results->getTax(NewMexicoIncome::class));
    }
}
