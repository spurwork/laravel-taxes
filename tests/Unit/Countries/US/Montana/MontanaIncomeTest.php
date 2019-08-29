<?php

namespace Appleton\Taxes\Unit\Countries\US\Montana\MontanaIncome;

use Appleton\Taxes\Countries\US\Montana\MontanaIncome\MontanaIncome;
use Appleton\Taxes\Models\Countries\US\Montana\MontanaIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class MontanaIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testMontanaIncome($date, $exempt, $allowances, $earnings, $result)
    {
        MontanaIncomeTaxInformation::forUser($this->user)->update([
            'allowances' => $allowances,
            'exempt' => $exempt,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.montana'));
            $taxes->setWorkLocation($this->getLocation('us.montana'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(MontanaIncome::class));
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
                300,
                null,
            ],
            '1' => [
                'January 1, 2019 8am',
                false,
                0,
                300,
                10,
            ],
            '2' => [
                'January 1, 2019 8am',
                false,
                2,
                700,
                30,
            ],
            '3' => [
                'January 1, 2019 8am',
                false,
                0,
                700,
                34,
            ],
        ];
    }
}
