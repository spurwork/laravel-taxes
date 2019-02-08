<?php

namespace Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome;

use Appleton\Taxes\Countries\US\FederalIncome\FederalIncome;
use Appleton\Taxes\Models\Countries\US\FederalIncomeTaxInformation;
use Appleton\Taxes\Models\Countries\US\Georgia\GeorgiaIncomeTaxInformation;
use Appleton\Taxes\Countries\US\Georgia\GeorgiaIncome\GeorgiaIncome;
use Carbon\Carbon;

class GeorgiaIncomeTest extends \TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testGeorgiaIncome($date, $filing_status, $allowances, $personal_allowances, $additional_withholding, $exempt, $earnings, $supplemental_earnings, $pay_periods, $use_default, $result)
    {
        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        GeorgiaIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => $additional_withholding,
            'exempt' => $exempt,
            'allowances' => $allowances,
            'personal_allowances' => $personal_allowances,
            'filing_status' => $filing_status,
        ]);

        if ($use_default) {
            GeorgiaIncomeTaxInformation::forUser($this->user)->delete();
        }

        $results = $this->taxes->calculate(function ($taxes) use ($earnings, $supplemental_earnings, $pay_periods) {
            $taxes->setHomeLocation($this->getLocation('us.georgia'));
            $taxes->setWorkLocation($this->getLocation('us.georgia'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setSupplementalEarnings($supplemental_earnings);
            $taxes->setPayPeriods($pay_periods);
        });

        $this->assertSame($result, $results->getTax(GeorgiaIncome::class));
    }

    public function provideTestData()
    {
        return [
            [
                'date' => 'January 1, 2018 8am',
                'filing_status' => GeorgiaIncome::FILING_SINGLE,
                'allowances' => 0,
                'personal_allowances' => 0,
                'additional_withholding' => 0,
                'exempt' => false,
                'earnings' => 66.68,
                'supplemental_earnings' => 0,
                'pay_periods' => 260,
                'use_default' => false,
                'result' => 2.73,
            ],
            [
                'date' => 'January 1, 2018 8am',
                'filing_status' => GeorgiaIncome::FILING_SINGLE,
                'allowances' => 0,
                'personal_allowances' => 0,
                'additional_withholding' => 0,
                'exempt' => false,
                'earnings' => 680,
                'supplemental_earnings' => 0,
                'pay_periods' => 52,
                'use_default' => false,
                'result' => 34.49,
            ],
            [
                'date' => 'January 1, 2018 8am',
                'filing_status' => GeorgiaIncome::FILING_SINGLE,
                'allowances' => 0,
                'personal_allowances' => 0,
                'additional_withholding' => 10,
                'exempt' => false,
                'earnings' => 0,
                'supplemental_earnings' => 0,
                'pay_periods' => 260,
                'use_default' => false,
                'result' => 0.00,
            ],
            [
                'date' => 'January 1, 2018 8am',
                'filing_status' => GeorgiaIncome::FILING_SINGLE,
                'allowances' => 0,
                'personal_allowances' => 0,
                'additional_withholding' => 10,
                'exempt' => false,
                'earnings' => 66.68,
                'supplemental_earnings' => 0,
                'pay_periods' => 260,
                'use_default' => false,
                'result' => 12.73,
            ],
            [
                'date' => 'January 1, 2018 8am',
                'filing_status' => GeorgiaIncome::FILING_SINGLE,
                'allowances' => 0,
                'personal_allowances' => 0,
                'additional_withholding' => 0,
                'exempt' => false,
                'earnings' => 100,
                'supplemental_earnings' => 100,
                'pay_periods' => 1,
                'use_default' => false,
                'result' => 2.00,
            ],
            [
                'date' => 'January 1, 2018 8am',
                'filing_status' => GeorgiaIncome::FILING_SINGLE,
                'allowances' => 0,
                'personal_allowances' => 0,
                'additional_withholding' => 0,
                'exempt' => false,
                'earnings' => 9,
                'supplemental_earnings' => 0,
                'pay_periods' => 260,
                'use_default' => false,
                'result' => 0.00,
            ],
            [
                'date' => 'January 1, 2018 8am',
                'filing_status' => GeorgiaIncome::FILING_SINGLE,
                'allowances' => 0,
                'personal_allowances' => 0,
                'additional_withholding' => 0,
                'exempt' => false,
                'earnings' => 0,
                'supplemental_earnings' => 0,
                'pay_periods' => 260,
                'use_default' => true,
                'result' => 0.00,
            ],
            [
                'date' => 'January 1, 2018 8am',
                'filing_status' => GeorgiaIncome::FILING_SINGLE,
                'allowances' => 0,
                'personal_allowances' => 0,
                'additional_withholding' => 0,
                'exempt' => false,
                'earnings' => 66.68,
                'supplemental_earnings' => 0,
                'pay_periods' => 260,
                'use_default' => true,
                'result' => 2.73,
            ],
            [
                'date' => 'January 1, 2018 8am',
                'filing_status' => GeorgiaIncome::FILING_SINGLE,
                'allowances' => 0,
                'personal_allowances' => 0,
                'additional_withholding' => 0,
                'exempt' => true,
                'earnings' => 66.68,
                'supplemental_earnings' => 0,
                'pay_periods' => 260,
                'use_default' => false,
                'result' => 0.00,
            ],
            [
                'date' => 'January 1, 2018 8am',
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
                'allowances' => 0,
                'personal_allowances' => 1,
                'additional_withholding' => 0,
                'exempt' => false,
                'earnings' => 412.5,
                'supplemental_earnings' => 0,
                'pay_periods' => 52,
                'use_default' => false,
                'result' => 16.25,
            ],
            [
                'date' => 'January 1, 2019 8am',
                'filing_status' => GeorgiaIncome::FILING_SINGLE,
                'allowances' => 0,
                'personal_allowances' => 0,
                'additional_withholding' => 0,
                'exempt' => false,
                'earnings' => 66.68,
                'supplemental_earnings' => 0,
                'pay_periods' => 260,
                'use_default' => false,
                'result' => 2.15,
            ],
            [
                'date' => 'January 1, 2019 8am',
                'filing_status' => GeorgiaIncome::FILING_SINGLE,
                'allowances' => 0,
                'personal_allowances' => 0,
                'additional_withholding' => 0,
                'exempt' => false,
                'earnings' => 680,
                'supplemental_earnings' => 0,
                'pay_periods' => 52,
                'use_default' => false,
                'result' => 30.69,
            ],
            [
                'date' => 'January 1, 2019 8am',
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_BOTH_WORKING,
                'allowances' => 1,
                'personal_allowances' => 1,
                'additional_withholding' => 0,
                'exempt' => false,
                'earnings' => 300,
                'supplemental_earnings' => 0,
                'pay_periods' => 52,
                'use_default' => false,
                'result' => 4.30,
            ],
            [
                'date' => 'January 1, 2019 8am',
                'filing_status' => GeorgiaIncome::FILING_MARRIED_JOINT_ONE_WORKING,
                'allowances' => 0,
                'personal_allowances' => 1,
                'additional_withholding' => 0,
                'exempt' => false,
                'earnings' => 300,
                'supplemental_earnings' => 0,
                'pay_periods' => 52,
                'use_default' => false,
                'result' => 2.8,
            ],
        ];
    }
}
