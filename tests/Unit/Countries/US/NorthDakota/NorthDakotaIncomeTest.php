<?php

namespace Appleton\Taxes\Unit\Countries\US\NorthDakota\NorthDakotaIncome;

use Appleton\Taxes\Countries\US\NorthDakota\NorthDakotaIncome\NorthDakotaIncome;
use Appleton\Taxes\Models\Countries\US\NorthDakota\NorthDakotaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class NorthDakotaIncomeTest extends TestCase
{
    /**
    * @dataProvider provideTestData
    */
    public function testNorthDakotaIncome($date, $exempt, $filing_status, $exemptions, $earnings, $result)
    {
        NorthDakotaIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => $exemptions,
            'exempt' => $exempt,
            'filing_status' => $filing_status,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.north_dakota'));
            $taxes->setWorkLocation($this->getLocation('us.north_dakota'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(NorthDakotaIncome::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // filing status
        // exemptions
        // earnings
        // results
        return [
            // exempt, should be null
            '0' => [
                'January 1, 2019 8am',
                true,
                NorthDakotaIncome::FILING_SINGLE,
                0,
                300,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                false,
                NorthDakotaIncome::FILING_SINGLE,
                0,
                300,
                2,
            ],
            '2' => [
                'January 1, 2019 8am',
                false,
                NorthDakotaIncome::FILING_SINGLE,
                2,
                1000,
                8,
            ],
            '3' => [
                'January 1, 2019 8am',
                false,
                NorthDakotaIncome::FILING_SINGLE,
                2,
                2000,
                29,
            ],
            '4' => [
                'January 1, 2019 8am',
                false,
                NorthDakotaIncome::FILING_MARRIED,
                2,
                1000,
                7,
            ],
            '5' => [
                'January 1, 2019 8am',
                false,
                NorthDakotaIncome::FILING_MARRIED,
                0,
                2000,
                25,
            ],
            '6' => [
                'January 1, 2019 8am',
                false,
                NorthDakotaIncome::FILING_MARRIED,
                2,
                2000,
                22,
            ],
            '7' => [
                'January 1, 2019 8am',
                false,
                NorthDakotaIncome::FILING_SINGLE,
                0,
                50,
                null,
            ],
        ];
    }
}
