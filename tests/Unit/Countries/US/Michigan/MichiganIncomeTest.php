<?php

namespace Appleton\Taxes\Countries\US\Michigan\MichiganIncome;

use Appleton\Taxes\Models\Countries\US\Michigan\MichiganIncomeTaxInformation;
use Carbon\Carbon;

class MichiganIncomeTest extends \TestCase
{
    public function testMichiganIncomeOneExemption()
    {
        MichiganIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'exempt' => false,
            'dependents' => 1,
            'filing_status' => MichiganIncome::FILING_SINGLE,
        ]);

        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.michigan'));
            $taxes->setWorkLocation($this->getLocation('us.michigan'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(300.00);
            $taxes->setSupplementalEarnings(0);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(9.15, $results->getTax(MichiganIncome::class));
    }

    public function testMichiganIncomeThreeExemption()
    {
        MichiganIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => 0,
            'exempt' => false,
            'dependents' => 3,
            'filing_status' => MichiganIncome::FILING_SINGLE,
        ]);

        Carbon::setTestNow(
            Carbon::parse('January 1, 2019 8am', 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) {
            $taxes->setHomeLocation($this->getLocation('us.michigan'));
            $taxes->setWorkLocation($this->getLocation('us.michigan'));
            $taxes->setUser($this->user);
            $taxes->setEarnings(384.62);
            $taxes->setSupplementalEarnings(0);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame(5.55, $results->getTax(MichiganIncome::class));
    }
}
