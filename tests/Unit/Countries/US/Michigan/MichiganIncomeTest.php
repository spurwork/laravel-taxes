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

    // public function provideTestData()
    // {
    //     return [
    //         [
    //             'date' => 'January 1, 2018 8am',
    //             'filing_status' => MichiganIncome::FILING_SINGLE,
    //             'allowances' => 0,
    //             'personal_allowances' => 0,
    //             'additional_withholding' => 0,
    //             'exempt' => false,
    //             'earnings' => 66.68,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 260,
    //             'use_default' => false,
    //             'result' => 2.73,
    //         ],
    //         [
    //             'date' => 'January 1, 2018 8am',
    //             'filing_status' => MichiganIncome::FILING_SINGLE,
    //             'allowances' => 0,
    //             'personal_allowances' => 0,
    //             'additional_withholding' => 0,
    //             'exempt' => false,
    //             'earnings' => 680,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 52,
    //             'use_default' => false,
    //             'result' => 34.49,
    //         ],
    //         [
    //             'date' => 'January 1, 2018 8am',
    //             'filing_status' => MichiganIncome::FILING_SINGLE,
    //             'allowances' => 0,
    //             'personal_allowances' => 0,
    //             'additional_withholding' => 10,
    //             'exempt' => false,
    //             'earnings' => 0,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 260,
    //             'use_default' => false,
    //             'result' => 0.00,
    //         ],
    //         [
    //             'date' => 'January 1, 2018 8am',
    //             'filing_status' => MichiganIncome::FILING_SINGLE,
    //             'allowances' => 0,
    //             'personal_allowances' => 0,
    //             'additional_withholding' => 10,
    //             'exempt' => false,
    //             'earnings' => 66.68,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 260,
    //             'use_default' => false,
    //             'result' => 12.73,
    //         ],
    //         [
    //             'date' => 'January 1, 2018 8am',
    //             'filing_status' => MichiganIncome::FILING_SINGLE,
    //             'allowances' => 0,
    //             'personal_allowances' => 0,
    //             'additional_withholding' => 0,
    //             'exempt' => false,
    //             'earnings' => 100,
    //             'supplemental_earnings' => 100,
    //             'pay_periods' => 1,
    //             'use_default' => false,
    //             'result' => 2.00,
    //         ],
    //         [
    //             'date' => 'January 1, 2018 8am',
    //             'filing_status' => MichiganIncome::FILING_SINGLE,
    //             'allowances' => 0,
    //             'personal_allowances' => 0,
    //             'additional_withholding' => 0,
    //             'exempt' => false,
    //             'earnings' => 9,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 260,
    //             'use_default' => false,
    //             'result' => 0.00,
    //         ],
    //         [
    //             'date' => 'January 1, 2018 8am',
    //             'filing_status' => MichiganIncome::FILING_SINGLE,
    //             'allowances' => 0,
    //             'personal_allowances' => 0,
    //             'additional_withholding' => 0,
    //             'exempt' => false,
    //             'earnings' => 0,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 260,
    //             'use_default' => true,
    //             'result' => 0.00,
    //         ],
    //         [
    //             'date' => 'January 1, 2018 8am',
    //             'filing_status' => MichiganIncome::FILING_SINGLE,
    //             'allowances' => 0,
    //             'personal_allowances' => 0,
    //             'additional_withholding' => 0,
    //             'exempt' => false,
    //             'earnings' => 66.68,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 260,
    //             'use_default' => true,
    //             'result' => 2.73,
    //         ],
    //         [
    //             'date' => 'January 1, 2018 8am',
    //             'filing_status' => MichiganIncome::FILING_SINGLE,
    //             'allowances' => 0,
    //             'personal_allowances' => 0,
    //             'additional_withholding' => 0,
    //             'exempt' => true,
    //             'earnings' => 66.68,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 260,
    //             'use_default' => false,
    //             'result' => 0.00,
    //         ],
    //         [
    //             'date' => 'January 1, 2018 8am',
    //             'filing_status' => MichiganIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
    //             'allowances' => 0,
    //             'personal_allowances' => 1,
    //             'additional_withholding' => 0,
    //             'exempt' => false,
    //             'earnings' => 412.5,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 52,
    //             'use_default' => false,
    //             'result' => 16.25,
    //         ],
    //         [
    //             'date' => 'January 1, 2019 8am',
    //             'filing_status' => MichiganIncome::FILING_SINGLE,
    //             'allowances' => 0,
    //             'personal_allowances' => 0,
    //             'additional_withholding' => 0,
    //             'exempt' => false,
    //             'earnings' => 66.68,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 260,
    //             'use_default' => false,
    //             'result' => 2.15,
    //         ],
    //         [
    //             'date' => 'January 1, 2019 8am',
    //             'filing_status' => MichiganIncome::FILING_SINGLE,
    //             'allowances' => 0,
    //             'personal_allowances' => 0,
    //             'additional_withholding' => 0,
    //             'exempt' => false,
    //             'earnings' => 680,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 52,
    //             'use_default' => false,
    //             'result' => 30.69,
    //         ],
    //         [
    //             'date' => 'January 1, 2019 8am',
    //             'filing_status' => MichiganIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
    //             'allowances' => 1,
    //             'personal_allowances' => 1,
    //             'additional_withholding' => 0,
    //             'exempt' => false,
    //             'earnings' => 300,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 52,
    //             'use_default' => false,
    //             'result' => 4.30,
    //         ],
    //         [
    //             'date' => 'January 1, 2019 8am',
    //             'filing_status' => MichiganIncome::FILING_MARRIED_JOINT_ONE_WORKING,
    //             'allowances' => 0,
    //             'personal_allowances' => 1,
    //             'additional_withholding' => 0,
    //             'exempt' => false,
    //             'earnings' => 300,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 52,
    //             'use_default' => false,
    //             'result' => 2.8,
    //         ],
    //         [
    //             'date' => 'January 1, 2019 8am',
    //             'filing_status' => MichiganIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
    //             'allowances' => 1,
    //             'personal_allowances' => 2,
    //             'additional_withholding' => 0,
    //             'exempt' => false,
    //             'earnings' => 300,
    //             'supplemental_earnings' => 0,
    //             'pay_periods' => 52,
    //             'use_default' => false,
    //             'result' => 0.88,
    //         ],
    //     ];
    // }
}
