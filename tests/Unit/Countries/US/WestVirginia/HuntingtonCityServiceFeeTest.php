<?php


namespace Appleton\Taxes\Unit\Countries\US\WestVirginia;


use Appleton\Taxes\Countries\US\WestVirginia\HuntingtonCityServiceFee\HuntingtonCityServiceFee;
use Carbon\Carbon;

class HuntingtonCityServiceFeeTest extends \TestCase
{
    public function testNoWeekToDate()
    {
        Carbon::setTestNow(Carbon::parse('2019-01-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.west_virginia.charleston'));
            $taxes->setWorkLocation($this->getLocation('us.west_virginia.huntington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.00, $results->getTax(HuntingtonCityServiceFee::class));
    }

    public function testWithWeekToDate()
    {
        Carbon::setTestNow(Carbon::parse('2019-01-01'));

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.west_virginia.charleston'));
            $taxes->setWorkLocation($this->getLocation('us.west_virginia.huntington'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300);
            $taxes->setPayPeriods(52);
            $taxes->setWtdEarnings(0.1);
        });

        $this->assertNull($results->getTax(HuntingtonCityServiceFee::class));
    }
}