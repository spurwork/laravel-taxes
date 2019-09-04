<?php

namespace Appleton\Taxes\Unit\Countries\US\Arkansas;

use Appleton\Taxes\Countries\US\Arkansas\ArkansasIncome\ArkansasIncome;
use Appleton\Taxes\Models\Countries\US\Arkansas\ArkansasIncomeTaxInformation;
use Carbon\Carbon;
use TestCase;

class ArkansasIncomeTest extends TestCase
{
    /**
     * @dataProvider provideTestData
     */
    public function testVermontIncome(int $exemptions, int $additional_withholding,
                                      bool $exempt, float $earnings, ?float $result): void
    {
        Carbon::setTestNow('2019-01-01');

        ArkansasIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => $exemptions,
            'additional_withholding' => $additional_withholding,
            'exempt' => $exempt,
        ]);

        $results = $this->taxes->calculate(function ($taxes) use ($earnings) {
            $taxes->setHomeLocation($this->getLocation('us.arkansas'));
            $taxes->setWorkLocation($this->getLocation('us.arkansas'));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(ArkansasIncome::class));
    }

    public function provideTestData(): array
    {
        // [$allowances, $additional_withholding, $exempt, $earnings, $result]
        return [
            'test case 1' => [0, 0, false, 961.54, 45.40],
            'test case 2' => [3, 0, false, 961.54, 43.90],
            'bracket 1' => [0, 0, false, 75.0, 0.3],
            'bracket 2' => [0, 0, false, 175.0, 1.96],
            'bracket 3' => [0, 0, false, 275.0, 5.08],
            'bracket 4' => [0, 0, false, 400.0, 10.50],
            'bracket 5' => [0, 0, false, 700.0, 27.52],
            'bracket 6' => [0, 0, false, 1000.0, 48.06],
            'additional withholding' => [0, 10, false, 961.54, 55.40],
            'exempt' => [0, 0, true, 961.54, null],
        ];
    }
}
