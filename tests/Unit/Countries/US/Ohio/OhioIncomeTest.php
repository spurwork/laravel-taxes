<?php

namespace Appleton\Taxes\Unit\Countries\US\Ohio\OhioIncome;

use Appleton\Taxes\Countries\US\Ohio\OhioIncome\OhioIncome;
use Appleton\Taxes\Models\Countries\US\Ohio\OhioIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class OhioIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testOhioIncome($date, $exempt, $dependents, $earnings, $result)
    {
        OhioIncomeTaxInformation::forUser($this->user)->update([
            'dependents' => $dependents,
            'exempt' => $exempt,
        ]);

        Carbon::setTestNow(
            Carbon::parse($date, 'America/Chicago')->setTimezone('UTC')
        );

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.ohio'));
            $taxes->setWorkLocation($this->getLocation('us.ohio'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(OhioIncome::class));
    }

    public function provideTestData()
    {
        // date
        // exempt
        // dependents
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
                50,
                0.26,
            ],
            '2' => [
                'January 1, 2019 8am',
                false,
                2,
                300,
                3.32,
            ],
            '3' => [
                'January 1, 2019 8am',
                false,
                5,
                2000,
                64.86,
            ],
            '4' => [
                'January 1, 2019 8am',
                false,
                0,
                500,
                9.92,
            ],
            '5' => [
                'January 1, 2019 8am',
                false,
                2,
                700,
                15.56,
            ],
        ];
    }
}
