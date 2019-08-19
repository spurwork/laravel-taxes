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
    public function testConnecticutIncome($date, $exempt, $filing_status, $dependents, $reduced_withholding, $additional_withholding, $earnings, $result)
    {
        ConnecticutIncomeTaxInformation::forUser($this->user)->update([
            'additional_withholding' => $additional_withholding,
            'reduced_withholding' => $reduced_withholding,
            'dependents' => $dependents,
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
        // dependents
        // reduced withholding
        // additional withholding
        // earnings
        // result
        return [
            // exempt, should be null
            // '0' => [
            //     'January 1, 2019 8am',
            //     true,
            //     ConnecticutIncome::FILING_SINGLE,
            //     0,
            //     0,
            //     0,
            //     300,
            //     null,
            // ],
            '1' => [
                'January 1, 2019 8am',
                false,
                ConnecticutIncome::FILING_SINGLE,
                0,
                0,
                0,
                300,
                13.51,
            ],
            // '2' => [
            //     'January 1, 2019 8am',
            //     false,
            //     1,
            //     300,
            //     8.17,
            // ],
            // '3' => [
            //     'January 1, 2019 8am',
            //     false,
            //     3,
            //     550,
            //     17.02,
            // ],
            // '4' => [
            //     'January 1, 2019 8am',
            //     false,
            //     0,
            //     153.84,
            //     4.44,
            // ],
            // '5' => [
            //     'January 1, 2019 8am',
            //     false,
            //     2,
            //     673.07,
            //     28.19,
            // ],
            // '6' => [
            //     'January 1, 2019 8am',
            //     false,
            //     4,
            //     1000,
            //     44.32,
            // ],
        ];
    }
}
