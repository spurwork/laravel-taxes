<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\V20180101;

use Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\NewMexicoIncome as ParentNewMexicoIncome;
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

        $this->assertSame(0.49, $results->getTax(ParentNewMexicoIncome::class));
    }
}
