<?php

namespace Appleton\Taxes\Unit\Countries\US\Minnesota\MinnesotaIncome;

use Appleton\Taxes\Countries\US\Minnesota\MinnesotaIncome\MinnesotaIncome;
use Appleton\Taxes\Models\Countries\US\Minnesota\MinnesotaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class MinnesotaIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testMinnesotaIncome($date, $exempt, $allowances, $filing_status, $earnings, $result)
    {
        MinnesotaIncomeTaxInformation::forUser($this->user)->update([
            'allowances' => $allowances,
            'exempt' => $exempt,
            'filing_status' => $filing_status,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.minnesota'));
            $taxes->setWorkLocation($this->getLocation('us.minnesota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(MinnesotaIncome::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // allowances
        // earnings
        // results
        return [
            // exempt, should be null
            '0' => [
                'January 1, 2019 8am',
                true,
                0,
                MinnesotaIncome::FILING_SINGLE,
                300,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                false,
                0,
                MinnesotaIncome::FILING_SINGLE,
                300,
                13.58,
            ],
            '2' => [
                'January 1, 2019 8am',
                false,
                2,
                MinnesotaIncome::FILING_SINGLE,
                1000,
                47.05,
            ],
            '3' => [
                'January 1, 2019 8am',
                false,
                2,
                MinnesotaIncome::FILING_SINGLE,
                2000,
                118.47,
            ],
            '4' => [
                'January 1, 2019 8am',
                false,
                2,
                MinnesotaIncome::FILING_MARRIED,
                1000,
                35.44,
            ],
            '5' => [
                'January 1, 2019 8am',
                false,
                0,
                MinnesotaIncome::FILING_MARRIED,
                2000,
                116.06,
            ],
        ];
    }
}
