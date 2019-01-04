<?php

namespace Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\V20190101;

use Appleton\Taxes\Countries\US\NewMexico\NewMexicoIncome\NewMexicoIncome as ParentNewMexicoIncome;
use Appleton\Taxes\Models\Countries\US\NewMexico\NewMexicoIncomeTaxInformation;
use Carbon\Carbon;

class NewMexicoIncomeTest extends \TestCase
{
    public function testNewMexicoIncome()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
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

    public function testNewMexicoIncomeAllowancesLockedToMaxOf3()
    {
        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );

        NewMexicoIncomeTaxInformation::forUser($this->user)->update(['exemptions' => 3]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(400);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(1.52, $results->getTax(ParentNewMexicoIncome::class));

        NewMexicoIncomeTaxInformation::forUser($this->user)->update(['exemptions' => 5]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.new_mexico'));
            $taxes->setWorkLocation($this->getLocation('us.new_mexico'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(400);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(1.52, $results->getTax(ParentNewMexicoIncome::class));
    }
}
