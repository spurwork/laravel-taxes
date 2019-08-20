<?php

namespace Appleton\Taxes\Unit\Countries\US\Connecticut\ConnecticutIncome;

use Appleton\Taxes\Countries\US\Connecticut\ConnecticutIncome\ConnecticutIncome;
use Appleton\Taxes\Models\Countries\US\Connecticut\ConnecticutIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class ConnecticutIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testConnecticutIncome($date, $exempt, $filing_status, $reduced_withholding, $additional_withholding, $earnings, $result)
    {
        ConnecticutIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => $additional_withholding,
            'reduced_withholding' => $reduced_withholding,
            'filing_status' => $filing_status,
            'exempt' => $exempt,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.connecticut'));
            $taxes->setWorkLocation($this->getLocation('us.connecticut'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(ConnecticutIncome::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // filing status
        // reduced withholding
        // additional withholding
        // earnings
        // result
        return [
            // exempt, should be null
            '0' => [
                'January 1, 2019 8am',
                true,
                ConnecticutIncome::FILING_SINGLE,
                0,
                0,
                300,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_SINGLE,
                0,
                0,
                300,
                .09,
            ],
            '2' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_SINGLE,
                0,
                0,
                6000,
                400.92,
            ],
            '3' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_SINGLE,
                20,
                20,
                6000,
                400.92,
            ],
            '4' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED,
                0,
                0,
                600,
                1.66,
            ],
            '5' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED,
                0,
                0,
                6000,
                331.15,
            ],
            '6' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED,
                0,
                20,
                6000,
                351.15,
            ],
            '7' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED_FILING_JOINTLY_ONE_SPOUSE_WORKING,
                0,
                0,
                600,
                1.66,
            ],
            '8' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED_FILING_JOINTLY_ONE_SPOUSE_WORKING,
                0,
                0,
                6000,
                331.15,
            ],
            '9' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED_FILING_JOINTLY_ONE_SPOUSE_WORKING,
                0,
                20,
                6000,
                351.15,
            ],
            '10' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED_FILING_SEPARATELY,
                0,
                0,
                600,
                20.08,
            ],
            '11' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED_FILING_SEPARATELY,
                0,
                0,
                6000,
                400.92,
            ],
            '12' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED_FILING_SEPARATELY,
                0,
                20,
                6000,
                420.92,
            ],
            '13' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED_FILING_JOINTLY_COMBINED_INCOME_LESS_THAN_OR_EQUAL_TO,
                0,
                0,
                600,
                20.08,
            ],
            '14' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED_FILING_JOINTLY_COMBINED_INCOME_LESS_THAN_OR_EQUAL_TO,
                0,
                0,
                6000,
                400.92,
            ],
            '15' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED_FILING_JOINTLY_COMBINED_INCOME_LESS_THAN_OR_EQUAL_TO,
                20,
                0,
                6000,
                380.92,
            ],
            '16' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_HEAD_OF_HOUSEHOLD,
                0,
                0,
                600,
                4.58,
            ],
            '17' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_HEAD_OF_HOUSEHOLD,
                0,
                0,
                6000,
                336.92,
            ],
            '18' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_HEAD_OF_HOUSEHOLD,
                0,
                20,
                6000,
                356.92,
            ],
            '19' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED_JOINTLY_COMBINED_INCOME_GREATER_THAN,
                0,
                0,
                600,
                26.15,
            ],
            '20' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED_JOINTLY_COMBINED_INCOME_GREATER_THAN,
                0,
                0,
                6000,
                400.92,
            ],
            '21' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_MARRIED_JOINTLY_COMBINED_INCOME_GREATER_THAN,
                0,
                20,
                6000,
                420.92,
            ],
        ];
    }
}
