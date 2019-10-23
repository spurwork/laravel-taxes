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
    public function testArkansasIncome(int $exemptions, int $additional_withholding,
                                       bool $exempt, float $earnings, ?float $result,
                                       string $home_location, string $work_location, bool $ar_tx_exempt): void
    {
        Carbon::setTestNow('2019-01-01');

        ArkansasIncomeTaxInformation::forUser($this->user)->update([
            'exemptions' => $exemptions,
            'additional_withholding' => $additional_withholding,
            'exempt' => $exempt,
            'ar_tx_exempt' => $ar_tx_exempt,
        ]);

        $results = $this->taxes->calculate(function ($taxes) use ($earnings, $home_location, $work_location) {
            $taxes->setHomeLocation($this->getLocation($home_location));
            $taxes->setWorkLocation($this->getLocation($work_location));
            $taxes->setUser($this->user);
            $taxes->setEarnings($earnings);
            $taxes->setPayPeriods(52);
        });

        $this->assertSame($result, $results->getTax(ArkansasIncome::class));
    }

    public function provideTestData(): array
    {
        return [
            'test case 1' => [0, 0, false, 961.54, 45.40, 'us.arkansas', 'us.arkansas', false],
            'test case 2' => [3, 0, false, 961.54, 43.90, 'us.arkansas', 'us.arkansas', false],
            'bracket 1' => [0, 0, false, 75.0, 0.3, 'us.arkansas', 'us.arkansas', false],
            'bracket 2' => [0, 0, false, 175.0, 1.96, 'us.arkansas', 'us.arkansas', false],
            'bracket 3' => [0, 0, false, 275.0, 5.08, 'us.arkansas', 'us.arkansas', false],
            'bracket 4' => [0, 0, false, 400.0, 10.50, 'us.arkansas', 'us.arkansas', false],
            'bracket 5' => [0, 0, false, 700.0, 27.52, 'us.arkansas', 'us.arkansas', false],
            'bracket 6' => [0, 0, false, 1000.0, 48.06, 'us.arkansas', 'us.arkansas', false],
            'additional withholding' => [0, 10, false, 961.54, 55.40, 'us.arkansas', 'us.arkansas', false],
            'exempt' => [0, 0, true, 961.54, null, 'us.arkansas', 'us.arkansas', false],
            'texarkana1' => [0, 0, false, 75.0, 0.3, 'us.arkansas.texarkana', 'us.arkansas.texarkana', false],
            'texarkana2' => [0, 0, false, 75.0, 0.3, 'us.arkansas.texarkana', 'us.arkansas', false],
            'texarkana3' => [0, 0, false, 75.0, 0.3, 'us.arkansas', 'us.arkansas.texarkana', false],
            'texarkana4' => [0, 0, false, 75.0, null, 'us.texas.texarkana', 'us.arkansas.texarkana', false],
            'texarkana5' => [0, 0, false, 75.0, 0.3, 'us.texas', 'us.arkansas.texarkana', false],
            'texarkana6' => [0, 0, false, 75.0, 0.3, 'us.arkansas.texarkana', 'us.texas', false],
            'texarkana7' => [0, 0, false, 75.0, 0.3, 'us.arkansas.texarkana', 'us.texas.texarkana', false],
            'texarkana8' => [0, 0, false, 75.0, null, 'us.arkansas.texarkana', 'us.texas.texarkana', true],
            'texarkana9' => [0, 0, false, 75.0, null, 'us.arkansas', 'us.texas', false],
            'texarkana10' => [0, 0, false, 75.0, null, 'us.arkansas', 'us.texas.texarkana', false],
        ];
    }
}
