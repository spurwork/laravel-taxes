<?php

namespace Appleton\Taxes\Countries\US\Colorado\ColoradoIncome;

use Appleton\Taxes\Models\Countries\US\Colorado\ColoradoIncomeTaxInformation;
use Carbon\Carbon;

class ColoradoIncomeTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();

        Carbon::setTestNow(
            Carbon::parse('January 1, 2018 8am', 'America/Chicago')->setTimezone('UTC')
        );
    }

    public function testColoradoIncome()
    {
        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.colorado'));
            $taxes->setWorkLocation($this->getLocation('us.colorado'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(1000);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(38.00, $results->getTax(ColoradoIncome::class));

        ColoradoIncomeTaxInformation::forUser($this->user)->update(['filing_status' => ColoradoIncome::FILING_MARRIED]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.colorado'));
            $taxes->setWorkLocation($this->getLocation('us.colorado'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(1000);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(33.00, $results->getTax(ColoradoIncome::class));
    }

    public function testIncomeExemptions()
    {
        ColoradoIncomeTaxInformation::forUser($this->user)->update(['exemptions' => 1]);

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.colorado'));
            $taxes->setWorkLocation($this->getLocation('us.colorado'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(1000);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(35.00, $results->getTax(ColoradoIncome::class));
    }
}
