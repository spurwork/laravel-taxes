<?php

namespace Appleton\Taxes\Unit\Countries\US\WashingtonDC\WashingtonDCIncome;

use Appleton\Taxes\Countries\US\WashingtonDC\WashingtonDCIncome\WashingtonDCIncome;
use Appleton\Taxes\Models\Countries\US\WashingtonDC\WashingtonDCIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class WashingtonDCIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testWashingtonDCIncome($date, $filing_status, $exempt, $dependents, $earnings, $result)
    {
        WashingtonDCIncomeTaxInformation::forUser($this->user)->update([
            'exempt' => $exempt,
            'filing_status' => $filing_status,
            'dependents' => $dependents,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.washingtondc'));
            $taxes->setWorkLocation($this->getLocation('us.washingtondc'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(WashingtonDCIncome::class));
    }

    public function provideTestData()
    {
        // date
        // filing status
        // exempt
        // dependents
        // earnings
        // results
        return [
            // exempt, should be 0
            '0' => [
                'January 1, 2019 8am',
                WashingtonDCIncome::FILING_SINGLE,
                true,
                0,
                300,
                0,
            ],
            '1' => [
                'January 1, 2019 8am',
                WashingtonDCIncome::FILING_SINGLE,
                false,
                0,
                300,
                14.15,
            ],
            '2' => [
                'January 1, 2019 8am',
                WashingtonDCIncome::FILING_SINGLE,
                false,
                2,
                1000,
                46.93,
            ],
            '3' => [
                'January 1, 2019 8am',
                WashingtonDCIncome::FILING_SINGLE,
                false,
                2,
                2000,
                125.66,
            ],
            '4' => [
                'January 1, 2019 8am',
                WashingtonDCIncome::FILING_MARRIED_FILING_JOINTLY,
                false,
                0,
                3500,
                266.73,
            ],
            '5' => [
                'January 1, 2019 8am',
                WashingtonDCIncome::FILING_MARRIED_FILING_SEPARATELY,
                false,
                0,
                100,
                4.0,
            ],
        ];
    }
}
