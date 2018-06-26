<?php

namespace Appleton\Taxes\Countries\US\Wisconsin\WisconsinIncome;

use Appleton\Taxes\Models\Countries\US\Wisconsin\WisconsinIncomeTaxInformation;
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
            $taxes->setEarnings(1000);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(56.87, $results->getTax(WisconsinIncome::class));

        WisconsinIncomeTaxInformation::forUser($this->user)->update(['filing_status' => WisconsinIncome::FILING_MARRIED]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wisconsin'));
            $taxes->setWorkLocation($this->getLocation('us.wisconsin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(1000);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(54.92, $results->getTax(WisconsinIncome::class));

        WisconsinIncomeTaxInformation::forUser($this->user)->update(['filing_status' => WisconsinIncome::FILING_SEPERATE]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.wisconsin'));
            $taxes->setWorkLocation($this->getLocation('us.wisconsin'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(1000);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(58.81, $results->getTax(WisconsinIncome::class));
    }

}
