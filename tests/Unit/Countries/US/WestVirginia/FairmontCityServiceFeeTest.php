<?php


namespace Appleton\Taxes\Unit\Countries\US\WestVirginia;


use Appleton\Taxes\Countries\US\WestVirginia\FairmontCityServiceFee\FairmontCityServiceFee;
use Carbon\Carbon;

class FairmontCityServiceFeeTest extends \TestCase
{
    public function testNoWeekToDate()
    {
        Carbon::setTestNow(Carbon::parse('2019-01-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.west_virginia.charleston'));
            $taxes->setWorkLocation($this->getLocation('us.west_virginia.fairmont'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(2.00, $results->getTax(FairmontCityServiceFee::class));
    }

    public function testWithWeekToDate()
    {
        Carbon::setTestNow(Carbon::parse('2019-01-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.west_virginia.charleston'));
            $taxes->setWorkLocation($this->getLocation('us.west_virginia.fairmont'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setWtdEarnings(0.1);
        });

        $this->assertNull($results->getTax(FairmontCityServiceFee::class));
    }

    public function testLivesInFairmont()
    {
        Carbon::setTestNow(Carbon::parse('2019-01-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.west_virginia.fairmont'));
            $taxes->setWorkLocation($this->getLocation('us.west_virginia.fairmont'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertNull($results->getTax(FairmontCityServiceFee::class));
    }
}