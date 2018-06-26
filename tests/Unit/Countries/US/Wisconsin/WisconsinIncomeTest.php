<?php

namespace Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome;

use Carbon\Carbon;

class WisconsinIncomeTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testWisconsinIncome()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wisconsin'));
            $taxes->setWorkLocation($this->getLocation('us.wisconsin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(100);
            $taxes->setPayPeriods(260);
        });

        $this->assertSame(4.07, $results->getTax(WisconsinIncome::class));
    }

//    public function testGeorgiaAdditionalWithholding()
//    {
//        GeorgiaIncomeTaxInformation::forUser($this->user)->update(['additional_withholding' => 10]);
//
//        $results = $this->taxes->calculate(function ($taxes) {
//            $taxes->setHomeLocation($this->getLocation('us.georgia'));
//            $taxes->setWorkLocation($this->getLocation('us.georgia'));
//            $taxes->setUser($this->user);
//            $taxes->setEarnings(0);
//            $taxes->setPayPeriods(260);
//        });
//
//        $this->assertSame(0.0, $results->getTax(GeorgiaIncome::class));
//
//        $results = $this->taxes->calculate(function ($taxes) {
//            $taxes->setHomeLocation($this->getLocation('us.georgia'));
//            $taxes->setWorkLocation($this->getLocation('us.georgia'));
//            $taxes->setUser($this->user);
//            $taxes->setEarnings(66.68);
//            $taxes->setPayPeriods(260);
//        });
//
//        $this->assertSame(12.74, $results->getTax(GeorgiaIncome::class));
//    }
//
//    public function testGeorgiaIncomeNonNegative()
//    {
//        $results = $this->taxes->calculate(function ($taxes) {
//            $taxes->setHomeLocation($this->getLocation('us.georgia'));
//            $taxes->setWorkLocation($this->getLocation('us.georgia'));
//            $taxes->setUser($this->user);
//            $taxes->setEarnings(10);
//            $taxes->setPayPeriods(260);
//        });
//
//        $this->assertSame(0.01, $results->getTax(GeorgiaIncome::class));
//    }
//
//    public function testGeorgiaIncomeUseDefault()
//    {
//        GeorgiaIncomeTaxInformation::forUser($this->user)->delete();
//
//        $results = $this->taxes->calculate(function ($taxes) {
//            $taxes->setHomeLocation($this->getLocation('us.georgia'));
//            $taxes->setWorkLocation($this->getLocation('us.georgia'));
//            $taxes->setUser($this->user);
//            $taxes->setEarnings(0);
//            $taxes->setPayPeriods(260);
//        });
//
//        $this->assertSame(0.0, $results->getTax(GeorgiaIncome::class));
//
//        $results = $this->taxes->calculate(function ($taxes) {
//            $taxes->setHomeLocation($this->getLocation('us.georgia'));
//            $taxes->setWorkLocation($this->getLocation('us.georgia'));
//            $taxes->setUser($this->user);
//            $taxes->setEarnings(66.68);
//            $taxes->setPayPeriods(260);
//        });
//
//        $this->assertSame(2.74, $results->getTax(GeorgiaIncome::class));
//    }

}
